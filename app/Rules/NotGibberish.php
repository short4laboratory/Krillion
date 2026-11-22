<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;
use Illuminate\Translation\PotentiallyTranslatedString;

/**
 * Rejects obvious keyboard mashing so nonsense can't farm "nobody said this" points.
 * These are cheap heuristics, not a dictionary check: invented-but-plausible names still pass.
 */
class NotGibberish implements ValidationRule
{
    /**
     * Rows of a QWERTY keyboard; any five consecutive keys from a row count as mashing.
     */
    private const array KEYBOARD_ROWS = ['qwertyuiop', 'asdfghjkl', 'zxcvbnm'];

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $text = Str::of((string) $value)->ascii()->lower()->toString();
        $letters = preg_replace('/[^a-z]/', '', $text);

        if (strlen($letters) < 2) {
            $fail('That answer needs at least a couple of letters.');

            return;
        }

        if (preg_match('/([a-z])\1{3,}/', $letters)) {
            $fail('That looks like a stuck key, not an answer.');

            return;
        }

        foreach (preg_split('/[^a-z]+/', $text, -1, PREG_SPLIT_NO_EMPTY) as $word) {
            if (strlen($word) >= 5 && ! preg_match('/[aeiouy]/', $word)) {
                $fail('That doesn\'t look like a real answer. Try something a human might say.');

                return;
            }
        }

        foreach (self::KEYBOARD_ROWS as $row) {
            for ($start = 0; $start + 5 <= strlen($row); $start++) {
                if (str_contains($letters, substr($row, $start, 5))) {
                    $fail('Keyboard mashing doesn\'t count. The deep sea can tell.');

                    return;
                }
            }
        }
    }
}
