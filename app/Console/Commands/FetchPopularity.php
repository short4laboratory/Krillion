<?php

namespace App\Console\Commands;

use App\Models\AcceptedAnswer;
use App\Services\WikipediaPopularity;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Sleep;
use Illuminate\Support\Str;

/**
 * Measures every answer on the active answer keys: Wikipedia page views (50 articles per request)
 * plus Datamuse word frequency. Each answer tries up to three article titles in turn — its explicit
 * article, "{label} {question suffix}" such as "Cancer (constellation)", then the bare label —
 * skipping titles that are missing or disambiguation pages.
 *
 * Resumable: answers already measured are skipped unless --fresh is given.
 */
#[Signature('krillion:fetch-popularity {--fresh : Re-measure answers that already have popularity}')]
#[Description('Fetch Wikipedia page views and dictionary frequency for every accepted answer')]
class FetchPopularity extends Command
{
    /**
     * Give up on a batch after this many rate-limit pauses in a row.
     */
    private const int MAX_ATTEMPTS = 5;

    public function handle(WikipediaPopularity $popularity): int
    {
        $answers = AcceptedAnswer::query()
            ->with('question')
            ->whereHas('question', fn ($query) => $query->active())
            ->when(! $this->option('fresh'), fn ($query) => $query->whereNull('popularity_fetched_at'))
            ->orderBy('id')
            ->get();

        if ($answers->isEmpty()) {
            $this->components->info('Every accepted answer already has a popularity measurement.');

            return self::SUCCESS;
        }

        $this->components->info("Measuring {$answers->count()} answers.");

        $articles = $this->resolveArticles($popularity, $answers);

        if ($articles === null) {
            $this->components->error('Wikipedia could not be reached. Run the command again to retry.');

            return self::FAILURE;
        }

        $unresolved = 0;

        foreach ($answers as $answer) {
            $article = $articles[$answer->id] ?? null;

            if ($article === null) {
                $unresolved++;
                $this->components->warn("{$answer->question->slug}: no Wikipedia article found for {$answer->label}.");

                continue;
            }

            // The word-frequency boost only applies when the answer's own name is its article. If it needed
            // disambiguating ("Quark (dairy product)", "Domestic turkey"), the word's frequency mostly
            // measures its other meaning, so it would inflate the answer's popularity.
            $isUnambiguous = Str::lower($article['title']) === Str::lower($answer->label);
            $frequency = $isUnambiguous ? ($popularity->dictionaryFrequency($answer->label) ?? 0.0) : 0.0;

            $answer->update([
                'resolved_article' => $article['title'],
                'pageviews' => $article['pageviews'],
                'dictionary_frequency' => $frequency,
                'weight' => WikipediaPopularity::weightFor($article['pageviews'], $frequency),
                'popularity_fetched_at' => now(),
            ]);

            $this->components->twoColumnDetail(
                "{$answer->question->slug}: {$answer->label}",
                "{$article['title']} · ".number_format($article['pageviews']).' views',
            );
        }

        if ($unresolved > 0) {
            $this->components->warn("{$unresolved} answers have no article yet; they score as a typical answer until fixed.");
        }

        return self::SUCCESS;
    }

    /**
     * Find each answer's article and page views, trying its candidate titles in order.
     *
     * @param  Collection<int, AcceptedAnswer>  $answers
     * @return array<int, array{title: string, pageviews: int}>|null
     */
    private function resolveArticles(WikipediaPopularity $popularity, Collection $answers): ?array
    {
        $candidates = $answers->mapWithKeys(fn (AcceptedAnswer $answer): array => [
            $answer->id => collect([
                $answer->article,
                $answer->question->article_suffix ? "{$answer->label} {$answer->question->article_suffix}" : null,
                $answer->label,
            ])->filter()->unique()->values()->all(),
        ]);

        $resolved = [];
        $knownTitles = [];

        for ($round = 0; $round < 3; $round++) {
            $pending = $candidates->filter(fn (array $titles, int $id): bool => ! isset($resolved[$id]) && isset($titles[$round]));
            $titles = $pending->map(fn (array $titles): string => $titles[$round])
                ->reject(fn (string $title): bool => array_key_exists($title, $knownTitles))
                ->unique()
                ->values();

            foreach ($titles->chunk(WikipediaPopularity::TITLES_PER_REQUEST) as $chunk) {
                $results = $this->pageviewsWithRetry($popularity, $chunk->values()->all());

                if ($results === null) {
                    return null;
                }

                $knownTitles = [...$knownTitles, ...$results];
                Sleep::for(60 / max(1, config('services.wikipedia.requests_per_minute')))->seconds();
            }

            foreach ($pending as $id => $titles) {
                if (($knownTitles[$titles[$round]] ?? null) !== null) {
                    $resolved[$id] = $knownTitles[$titles[$round]];
                }
            }
        }

        return $resolved;
    }

    /**
     * @param  list<string>  $titles
     * @return array<string, array{title: string, pageviews: int}|null>|null
     */
    private function pageviewsWithRetry(WikipediaPopularity $popularity, array $titles): ?array
    {
        for ($attempt = 1; $attempt <= self::MAX_ATTEMPTS; $attempt++) {
            if ($until = $popularity->backoffUntil()) {
                $this->components->warn("Rate limited; waiting until {$until->toTimeString()}.");
                Sleep::until($until);
            }

            $results = $popularity->pageviews($titles);

            if ($results !== null) {
                return $results;
            }
        }

        return null;
    }
}
