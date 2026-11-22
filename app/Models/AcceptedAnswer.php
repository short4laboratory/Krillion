<?php

namespace App\Models;

use Database\Factories\AcceptedAnswerFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * One correct answer on a question's answer key, plus how commonly people look it up.
 *
 * - key / alias_keys: normalized forms that match it ("bosnia" for Bosnia and Herzegovina)
 * - article: the Wikipedia article to measure, when the label alone would be ambiguous
 * - pageviews: Wikipedia page views over the last 60 days (how often people look it up)
 * - dictionary_frequency: Datamuse word frequency per million words, a small boost for everyday words
 * - weight: the combined popularity used for scoring (see WikipediaPopularity::weightFor)
 */
#[Fillable(['question_id', 'key', 'label', 'article', 'alias_keys', 'resolved_article', 'pageviews', 'dictionary_frequency', 'weight', 'popularity_fetched_at'])]
class AcceptedAnswer extends Model
{
    /** @use HasFactory<AcceptedAnswerFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'alias_keys' => 'array',
            'pageviews' => 'integer',
            'dictionary_frequency' => 'float',
            'weight' => 'float',
            'popularity_fetched_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<Question, $this>
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Every normalized form that counts as this answer.
     *
     * @return list<string>
     */
    public function matchKeys(): array
    {
        return [$this->key, ...($this->alias_keys ?? [])];
    }
}
