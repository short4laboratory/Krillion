<?php

namespace App\Models;

use App\Enums\DepthZone;
use App\Enums\FishClass;
use App\Services\AnswerScorer;
use Database\Factories\DiveFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * One play-through: seven questions, one descent into the trench.
 */
#[Fillable(['player_name', 'question_ids', 'total_score', 'question_started_at', 'completed_at'])]
class Dive extends Model
{
    /** @use HasFactory<DiveFactory> */
    use HasFactory, HasUlids;

    public const int QUESTIONS_PER_DIVE = 7;

    public const int SECONDS_PER_QUESTION = 25;

    /**
     * Extra seconds allowed after the countdown for the cast animation and a slow connection.
     */
    public const int DEADLINE_GRACE_SECONDS = 5;

    /**
     * Session key holding the ids of dives this browser started.
     */
    public const string SESSION_KEY = 'krillion.dives';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'question_ids' => 'array',
            'total_score' => 'integer',
            'question_started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    /**
     * @return HasMany<DiveAnswer, $this>
     */
    public function answers(): HasMany
    {
        return $this->hasMany(DiveAnswer::class)->orderBy('position');
    }

    public function isComplete(): bool
    {
        return $this->completed_at !== null;
    }

    /**
     * Start the countdown for the current question the first time it is shown.
     * Reloading the page keeps the original start time, so it can't reset the clock.
     */
    public function startQuestionClock(): void
    {
        if ($this->question_started_at === null && ! $this->isComplete()) {
            $this->update(['question_started_at' => now()]);
        }
    }

    public function secondsRemaining(): int
    {
        if ($this->question_started_at === null) {
            return self::SECONDS_PER_QUESTION;
        }

        $elapsed = (int) floor($this->question_started_at->diffInSeconds(now(), true));

        return max(0, self::SECONDS_PER_QUESTION - $elapsed);
    }

    /**
     * Whether an answer arriving now is too late to count, even allowing for the grace period.
     */
    public function isPastDeadline(): bool
    {
        return $this->question_started_at !== null
            && floor($this->question_started_at->diffInSeconds(now(), true)) > self::SECONDS_PER_QUESTION + self::DEADLINE_GRACE_SECONDS;
    }

    /**
     * The next unanswered question, or null once all seven are answered.
     */
    public function currentQuestion(): ?Question
    {
        $questionId = $this->question_ids[$this->answers()->count()] ?? null;

        return $questionId === null ? null : Question::query()->find($questionId);
    }

    /**
     * Whether the current browser session started this dive.
     */
    public function isOwnedBySession(): bool
    {
        return in_array($this->id, session()->get(self::SESSION_KEY, []), true);
    }

    public static function maxScore(): int
    {
        return self::QUESTIONS_PER_DIVE * AnswerScorer::MAX_POINTS;
    }

    /**
     * Fraction of the maximum score => depth in metres. Each ocean zone gets a fair share of the
     * score, so every answer visibly sinks the diver and a typical dive spends a few answers in the
     * twilight zone instead of rushing straight past it.
     *
     * @var list<array{0: float, 1: int}>
     */
    private const array DEPTH_CURVE = [
        [0.0, 0],
        [0.06, 200],
        [0.15, 500],
        [0.27, 1000],
        [0.42, 2500],
        [0.55, 4000],
        [0.72, 6000],
        [0.92, 10000],
        [1.0, DepthZone::CHALLENGER_DEEP_METERS],
    ];

    /**
     * Convert a score into metres below the surface by interpolating along DEPTH_CURVE.
     */
    public static function depthForScore(int $score): int
    {
        $fraction = min(1, max(0, $score / self::maxScore()));

        for ($i = 1; $i < count(self::DEPTH_CURVE); $i++) {
            [$upperFraction, $upperMeters] = self::DEPTH_CURVE[$i];

            if ($fraction <= $upperFraction) {
                [$lowerFraction, $lowerMeters] = self::DEPTH_CURVE[$i - 1];
                $progress = ($fraction - $lowerFraction) / ($upperFraction - $lowerFraction);

                return (int) round($lowerMeters + ($upperMeters - $lowerMeters) * $progress);
            }
        }

        return DepthZone::CHALLENGER_DEEP_METERS;
    }

    public function depthInMeters(): int
    {
        return self::depthForScore($this->total_score);
    }

    public function depthZone(): DepthZone
    {
        return DepthZone::fromDepth($this->depthInMeters());
    }

    /**
     * The fish this diver is, based on their average answer.
     */
    public function fishClass(): FishClass
    {
        return FishClass::fromPoints((int) floor($this->total_score / self::QUESTIONS_PER_DIVE));
    }

    /**
     * Which species of their class this diver is, fixed per dive.
     *
     * @return array{creature: string, name: string}
     */
    public function species(): array
    {
        return $this->fishClass()->speciesFor(crc32((string) $this->id));
    }
}
