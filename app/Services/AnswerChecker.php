<?php

namespace App\Services;

use App\Models\Question;
use App\Rules\NotGibberish;

/**
 * Decides whether a typed answer is on the question's answer key, a near miss worth suggesting
 * a correction for, or simply wrong. Used both by the instant check while typing and by the final submit.
 */
class AnswerChecker
{
    public function __construct(private AnswerMatcher $matcher) {}

    public function check(Question $question, string $answer): AnswerCheck
    {
        if ($accepted = $this->matcher->match($question, $answer)) {
            return new AnswerCheck(AnswerCheck::ACCEPTED, $accepted, '');
        }

        if ($suggestion = $this->matcher->suggest($question, $answer)) {
            return new AnswerCheck(AnswerCheck::SUGGESTION, $suggestion, "Did you mean “{$suggestion->label}”?");
        }

        return new AnswerCheck(AnswerCheck::REJECTED, null, $this->looksLikeGibberish($answer)
            ? 'That looks like keyboard mashing. Try a real answer!'
            : "“{$answer}” doesn't fit this one. Try another!");
    }

    private function looksLikeGibberish(string $answer): bool
    {
        $isGibberish = false;
        (new NotGibberish)->validate('answer', $answer, function () use (&$isGibberish): void {
            $isGibberish = true;
        });

        return $isGibberish;
    }
}
