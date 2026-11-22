<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Measures how commonly people look an answer up: Wikipedia page views over the last 60 days
 * (the closest public, official number to "how often is this searched"), with a small boost from
 * Datamuse word frequency for everyday words.
 *
 * Wikimedia rate-limits anonymous clients, so a 429 pauses requests until its Retry-After passes.
 */
class WikipediaPopularity
{
    public const string WIKIPEDIA_API = 'https://en.wikipedia.org/w/api.php';

    public const string DATAMUSE_API = 'https://api.datamuse.com/words';

    /**
     * The most article titles the Action API accepts in one request.
     */
    public const int TITLES_PER_REQUEST = 50;

    /**
     * The longest page-view window the Action API offers.
     */
    public const int PAGEVIEW_DAYS = 60;

    /**
     * Cache key holding the time until which Wikimedia has asked us to stop sending requests.
     */
    public const string BACKOFF_CACHE_KEY = 'wikipedia:backoff-until';

    private const int DEFAULT_BACKOFF_SECONDS = 60;

    /**
     * Page views for up to 50 article titles, following redirects ("Czechia" → "Czech Republic").
     *
     * Returns null when Wikipedia can't be reached or is rate limiting; otherwise an entry per requested
     * title that is null when the article doesn't exist or is a disambiguation page.
     *
     * @param  list<string>  $titles
     * @return array<string, array{title: string, pageviews: int}|null>|null
     */
    public function pageviews(array $titles): ?array
    {
        $titles = array_values(array_unique($titles));

        if (count($titles) > self::TITLES_PER_REQUEST) {
            throw new \InvalidArgumentException('Request at most '.self::TITLES_PER_REQUEST.' titles at a time.');
        }

        if ($titles === [] || $this->backoffUntil() !== null) {
            return $titles === [] ? [] : null;
        }

        $renamed = [];
        $pages = [];
        $continue = [];

        do {
            $response = $this->get(self::WIKIPEDIA_API, [
                'action' => 'query',
                'prop' => 'pageviews|pageprops',
                'ppprop' => 'disambiguation',
                'pvipdays' => self::PAGEVIEW_DAYS,
                'titles' => implode('|', $titles),
                'redirects' => 1,
                'format' => 'json',
                'formatversion' => 2,
                ...$continue,
            ]);

            if ($response === null || ! $this->succeeded($response)) {
                return null;
            }

            foreach ([...$response->json('query.normalized', []), ...$response->json('query.redirects', [])] as $rename) {
                $renamed[$rename['from']] = $rename['to'];
            }

            foreach ($response->json('query.pages', []) as $page) {
                $pages[$page['title']] = array_replace($pages[$page['title']] ?? [], $page);
            }

            $continue = $response->json('continue', []);
        } while ($continue !== []);

        return collect($titles)->mapWithKeys(function (string $title) use ($renamed, $pages): array {
            $resolved = $title;

            for ($hops = 0; isset($renamed[$resolved]) && $hops < 3; $hops++) {
                $resolved = $renamed[$resolved];
            }

            $page = $pages[$resolved] ?? null;
            $isUsable = $page !== null
                && ! ($page['missing'] ?? false)
                && ! ($page['invalid'] ?? false)
                && ! array_key_exists('disambiguation', $page['pageprops'] ?? []);

            return [$title => $isUsable
                ? ['title' => $page['title'], 'pageviews' => (int) array_sum(array_filter($page['pageviews'] ?? []))]
                : null];
        })->all();
    }

    /**
     * How often a word appears per million words of English, or 0 if Datamuse doesn't know it.
     * Returns null when Datamuse can't be reached.
     */
    public function dictionaryFrequency(string $term): ?float
    {
        $term = Str::lower(Str::squish($term));
        $response = $this->get(self::DATAMUSE_API, ['sp' => $term, 'md' => 'f', 'max' => 1]);

        if ($response === null || ! $response->successful()) {
            return null;
        }

        $entry = collect($response->json() ?? [])->first(
            fn (mixed $entry): bool => is_array($entry) && Str::lower($entry['word'] ?? '') === $term
        );
        $tag = collect($entry['tags'] ?? [])->first(fn (string $tag): bool => str_starts_with($tag, 'f:'));

        return $tag === null ? 0.0 : (float) substr($tag, 2);
    }

    /**
     * Combine the sources into one popularity number: page views, boosted up to ~3x
     * for everyday words people reach for first (log of corpus frequency).
     */
    public static function weightFor(int $pageviews, float $dictionaryFrequency): float
    {
        return $pageviews * (1 + log10(1 + $dictionaryFrequency));
    }

    /**
     * When Wikimedia has asked us to pause, the time we may resume.
     */
    public function backoffUntil(): ?Carbon
    {
        $until = Cache::get(self::BACKOFF_CACHE_KEY);

        return $until !== null && now()->lt($until) ? Carbon::parse($until) : null;
    }

    /**
     * @param  array<string, mixed>  $query
     */
    private function get(string $url, array $query): ?Response
    {
        try {
            return $this->client()->get($url, $query);
        } catch (ConnectionException $exception) {
            Log::warning('Popularity source unreachable.', ['url' => $url, 'error' => $exception->getMessage()]);

            return null;
        }
    }

    private function client(): PendingRequest
    {
        return Http::withUserAgent(config('services.wikipedia.user_agent'))
            ->timeout(config('services.wikipedia.timeout'))
            ->acceptJson();
    }

    private function succeeded(Response $response): bool
    {
        if (in_array($response->status(), [429, 503], true)) {
            $seconds = (int) ($response->header('Retry-After') ?: self::DEFAULT_BACKOFF_SECONDS);
            Cache::put(self::BACKOFF_CACHE_KEY, now()->addSeconds($seconds)->toIso8601String(), $seconds);
            Log::notice('Wikipedia requests paused by rate limiting.', ['seconds' => $seconds]);

            return false;
        }

        return $response->successful();
    }
}
