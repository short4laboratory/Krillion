<?php

namespace App\Services;

use App\Enums\FishClass;
use App\Models\AcceptedAnswer;
use App\Models\Question;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

/**
 * Scores a correct answer by how rarely people would think of it.
 *
 * Commonness blends two sources. Each answer's Wikipedia popularity (how often people look it up)
 * is the prior, scaled so the question's most looked-up answer counts as if REFERENCE_TOP_DIVERS
 * players had said it. Every answer real players give is added on top, so the crowd gradually
 * takes over as the game is played.
 */
class AnswerScorer
{
    public const int MAX_POINTS = 100;

    /**
     * How many imaginary divers the question's most looked-up answer is worth.
     */
    public const int REFERENCE_TOP_DIVERS = 250;

    /**
     * Even the most obvious correct answer is worth this much.
     */
    public const int MIN_CORRECT_POINTS = 10;

    /**
     * Scores are rounded to this step, matching the fish-class bands.
     */
    public const int POINT_STEP = 10;

    /**
     * An answer this many times rarer than the question's most popular answer earns full points.
     */
    private const int MAX_RARITY_RATIO = 100;

    /**
     * Below 1 this bends the curve upward, so moderately rare answers score generously
     * while full points still need a truly obscure one.
     */
    private const float GENEROSITY_CURVE = 0.65;

    public function score(Question $question, AcceptedAnswer $accepted): ScoredAnswer
    {
        $crowdCounts = $this->crowdCounts($question);
        $timesGivenByKey = $this->timesGivenByKey($question, $crowdCounts);
        $timesGiven = $timesGivenByKey[$accepted->key] ?? 0.0;

        $points = $timesGiven <= 0
            ? self::MAX_POINTS
            : $this->pointsFor($timesGiven, max($timesGivenByKey));

        return new ScoredAnswer(
            $accepted->key,
            $points,
            FishClass::fromPoints($points),
            $accepted->pageviews,
            (int) ($crowdCounts[$accepted->key] ?? 0),
        );
    }

    /**
     * Score an answer by how much rarer it is than the question's most popular answer (on a log scale),
     * from 10 for the favourite to 100 for an answer at least 100x rarer, rounded to the nearest 10.
     */
    public function pointsFor(float $timesGiven, float $topTimesGiven): int
    {
        $rarity = log10(max($timesGiven, $topTimesGiven) / $timesGiven) / log10(self::MAX_RARITY_RATIO);
        $points = self::MIN_CORRECT_POINTS
            + (self::MAX_POINTS - self::MIN_CORRECT_POINTS) * min(1, max(0, $rarity)) ** self::GENEROSITY_CURVE;

        return (int) (round($points / self::POINT_STEP) * self::POINT_STEP);
    }

    /**
     * The most popular answers for each question, by Wikipedia popularity plus crowd count.
     *
     * @param  Collection<int, Question>  $questions
     * @return array<int, list<string>>
     */
    public function mostCommonAnswers(Collection $questions, int $limit = 3): array
    {
        $questions = EloquentCollection::make($questions->all())->loadMissing('acceptedAnswers');

        return $questions->toBase()->mapWithKeys(function (Question $question) use ($limit): array {
            $timesGivenByKey = $this->timesGivenByKey($question, $this->crowdCounts($question));

            return [
                $question->id => $question->acceptedAnswers
                    ->filter(fn (AcceptedAnswer $accepted): bool => ($timesGivenByKey[$accepted->key] ?? 0) > 0)
                    ->sortByDesc(fn (AcceptedAnswer $accepted): float => $timesGivenByKey[$accepted->key])
                    ->take($limit)
                    ->pluck('label')
                    ->values()
                    ->all(),
            ];
        })->all();
    }

    /**
     * How many divers have given each answer so far.
     *
     * @return array<string, int>
     */
    private function crowdCounts(Question $question): array
    {
        return $question->diveAnswers()
            ->toBase()
            ->whereNotNull('answer_key')
            ->select('answer_key')
            ->selectRaw('count(*) as times_given')
            ->groupBy('answer_key')
            ->pluck('times_given', 'answer_key')
            ->map(fn (mixed $count): int => (int) $count)
            ->all();
    }

    /**
     * Effective "times given" per answer: scaled Wikipedia popularity plus real divers.
     * Answers whose popularity hasn't been fetched yet are treated as typical (the median).
     *
     * @param  array<string, int>  $crowdCounts
     * @return array<string, float>
     */
    private function timesGivenByKey(Question $question, array $crowdCounts): array
    {
        $acceptedAnswers = $question->loadMissing('acceptedAnswers')->acceptedAnswers;
        $knownWeights = $acceptedAnswers->pluck('weight')->filter(fn (?float $weight): bool => $weight !== null);
        $typicalWeight = $knownWeights->isEmpty() ? 1.0 : (float) $knownWeights->median();

        $weights = $acceptedAnswers->mapWithKeys(fn (AcceptedAnswer $accepted): array => [
            $accepted->key => $accepted->weight ?? $typicalWeight,
        ]);
        $topWeight = (float) $weights->max();

        $timesGiven = $topWeight > 0
            ? $weights->map(fn (float $weight): float => $weight / $topWeight * self::REFERENCE_TOP_DIVERS)->all()
            : [];

        foreach ($crowdCounts as $key => $count) {
            $timesGiven[$key] = ($timesGiven[$key] ?? 0) + $count;
        }

        return $timesGiven;
    }
}
