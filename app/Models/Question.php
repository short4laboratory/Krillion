<?php

namespace App\Models;

use Database\Factories\QuestionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A question with an answer key, such as "Name a landlocked country."
 *
 * `article_suffix` disambiguates Wikipedia lookups for its answers, e.g. "(constellation)"
 * so that "Cancer" measures the constellation rather than the disease.
 */
#[Fillable(['slug', 'prompt', 'placeholder', 'article_suffix', 'retired_at'])]
class Question extends Model
{
    /** @use HasFactory<QuestionFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'retired_at' => 'datetime',
        ];
    }

    /**
     * Questions still in rotation. Retired ones are kept only so old dives can show their results.
     *
     * @param  Builder<Question>  $query
     */
    #[Scope]
    protected function active(Builder $query): void
    {
        $query->whereNull('retired_at');
    }

    /**
     * @return HasMany<AcceptedAnswer, $this>
     */
    public function acceptedAnswers(): HasMany
    {
        return $this->hasMany(AcceptedAnswer::class);
    }

    /**
     * @return HasMany<DiveAnswer, $this>
     */
    public function diveAnswers(): HasMany
    {
        return $this->hasMany(DiveAnswer::class);
    }
}
