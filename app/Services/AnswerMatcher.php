<?php

namespace App\Services;

use App\Models\AcceptedAnswer;
use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

/**
 * Matches what a player typed against a question's answer key, and suggests the answer
 * they probably meant when they're close ("Lichtenstein" → "Liechtenstein").
 */
class AnswerMatcher
{
    /**
     * Answers shorter than this (once normalized) never get suggestions; too many short words look alike.
     */
    private const int MIN_SUGGESTION_LENGTH = 3;

    /**
     * The answer-key entry this answer counts as, matching names before aliases.
     */
    public function match(Question $question, string $answer): ?AcceptedAnswer
    {
        $key = $this->normalize($answer);

        if ($key === '') {
            return null;
        }

        $acceptedAnswers = $this->acceptedAnswers($question);

        return $acceptedAnswers->first(fn (AcceptedAnswer $accepted): bool => $accepted->key === $key)
            ?? $acceptedAnswers->first(fn (AcceptedAnswer $accepted): bool => in_array($key, $accepted->alias_keys ?? [], true));
    }

    /**
     * The answer they most likely meant: within a few typos (about one per three letters)
     * or spelled differently but sounding the same.
     */
    public function suggest(Question $question, string $answer): ?AcceptedAnswer
    {
        $key = $this->normalize($answer);

        if (strlen($key) < self::MIN_SUGGESTION_LENGTH) {
            return null;
        }

        $sound = metaphone($key);
        $best = null;
        $bestDistance = PHP_INT_MAX;

        foreach ($this->acceptedAnswers($question) as $accepted) {
            foreach ($accepted->matchKeys() as $candidate) {
                $distance = levenshtein($key, $candidate);
                $isCloseSpelling = $distance <= max(1, intdiv(strlen($candidate), 3));
                $soundsTheSame = $sound !== '' && $sound === metaphone($candidate);

                if (($isCloseSpelling || $soundsTheSame) && $distance < $bestDistance) {
                    $best = $accepted;
                    $bestDistance = $distance;
                }
            }
        }

        return $best;
    }

    /**
     * Reduce an answer to a comparison key so trivial differences don't matter:
     * "Bosnia & Herzegovina", "bosnia and herzegovina!" and "Bosnia-Herzegovina" style variations collapse together.
     */
    public function normalize(string $answer): string
    {
        return Str::of($answer)
            ->ascii()
            ->lower()
            ->replace('&', ' and ')
            ->replaceMatches('/[^a-z0-9\s]/', '')
            ->squish()
            ->replaceMatches('/^(the|a|an)\s+/', '')
            ->explode(' ')
            ->filter()
            // Only words ending in "s" are treated as plurals; Str::singular would otherwise
            // turn Latin-looking names like "Bosnia" into "bosnium".
            ->map(fn (string $word): string => str_ends_with($word, 's') ? Str::singular($word) : $word)
            ->implode('');
    }

    /**
     * @return Collection<int, AcceptedAnswer>
     */
    private function acceptedAnswers(Question $question): Collection
    {
        return $question->loadMissing('acceptedAnswers')->acceptedAnswers;
    }
}
