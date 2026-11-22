<?php

namespace App\Models;

use App\Enums\FishClass;
use Database\Factories\DiveAnswerFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * A player's answer to one question. These rows double as the crowd data that
 * makes answers less valuable as more people give them.
 *
 * `answer` is exactly what was typed; `acceptedAnswer` is the answer-key entry it counted as.
 * Answers from before answer keys existed have `encyclopedia_hits` instead of `pageviews`.
 */
#[Fillable(['dive_id', 'question_id', 'accepted_answer_id', 'position', 'answer', 'answer_key', 'points', 'pageviews', 'encyclopedia_hits', 'prior_divers', 'fish_class', 'timed_out'])]
class DiveAnswer extends Model
{
    /** @use HasFactory<DiveAnswerFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'position' => 'integer',
            'points' => 'integer',
            'pageviews' => 'integer',
            'encyclopedia_hits' => 'integer',
            'prior_divers' => 'integer',
            'fish_class' => FishClass::class,
            'timed_out' => 'boolean',
        ];
    }

    /**
     * The answer-key label this counted as, when it differs from what was typed
     * (e.g. "bosnia" counted as "Bosnia and Herzegovina").
     */
    public function countedAs(): ?string
    {
        $label = $this->acceptedAnswer?->label;

        if ($label === null || $this->answer === null) {
            return null;
        }

        return Str::lower(Str::squish($this->answer)) === Str::lower($label) ? null : $label;
    }

    /**
     * Which of its class's species this catch turned out to be (a Reef Dweller might be a blue tang).
     * Seeded by the answer's id so it's the same fish every time the page is shown. Misses catch nothing.
     *
     * @return array{creature: string, name: string}|null
     */
    public function species(): ?array
    {
        return $this->timed_out ? null : $this->fish_class->speciesFor((int) $this->id);
    }

    /**
     * The evidence behind the score, in words.
     */
    public function evidenceLabel(): string
    {
        if ($this->timed_out) {
            return 'Time ran out before anything was on the hook.';
        }

        $divers = match ($this->prior_divers) {
            0 => 'no diver said it before you',
            1 => '1 diver said it before you',
            default => number_format($this->prior_divers).' divers said it before you',
        };

        if ($this->pageviews === null && $this->encyclopedia_hits !== null) {
            return number_format($this->encyclopedia_hits)." encyclopedia articles pair it with this question, and {$divers}.";
        }

        $lookups = $this->pageviews === null
            ? 'Its Wikipedia popularity hasn\'t been measured yet'
            : 'Looked up '.self::compactNumber($this->pageviews).' times on Wikipedia in the last 60 days';

        return "{$lookups}, and {$divers}.";
    }

    /**
     * 1234567 → "1.2M", 45200 → "45.2K".
     */
    public static function compactNumber(int $number): string
    {
        return match (true) {
            $number >= 1_000_000 => rtrim(rtrim(number_format($number / 1_000_000, 1), '0'), '.').'M',
            $number >= 1_000 => rtrim(rtrim(number_format($number / 1_000, 1), '0'), '.').'K',
            default => number_format($number),
        };
    }

    /**
     * @return BelongsTo<Dive, $this>
     */
    public function dive(): BelongsTo
    {
        return $this->belongsTo(Dive::class);
    }

    /**
     * @return BelongsTo<Question, $this>
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * @return BelongsTo<AcceptedAnswer, $this>
     */
    public function acceptedAnswer(): BelongsTo
    {
        return $this->belongsTo(AcceptedAnswer::class);
    }
}
