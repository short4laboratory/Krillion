<?php

use App\Rules\NotGibberish;

function gibberishFailures(string $value): array
{
    $failures = [];
    (new NotGibberish)->validate('answer', $value, function (string $message) use (&$failures): void {
        $failures[] = $message;
    });

    return $failures;
}

it('accepts real and invented-but-plausible answers', function (string $value) {
    expect(gibberishFailures($value))->toBe([]);
})->with([
    'Buttermilk',
    'Maximillious the III Esquire',
    'Rhythm',
    'Cap\'n Crunch',
    'Jalapeños',
    'Ox',
    '7 Up',
]);

it('rejects keyboard mashing and nonsense', function (string $value, string $message) {
    expect(gibberishFailures($value))->toBe([$message]);
})->with([
    'too few letters' => ['12345', 'That answer needs at least a couple of letters.'],
    'stuck key' => ['Vanillaaaaa', 'That looks like a stuck key, not an answer.'],
    'no vowels' => ['bcdfgh', 'That doesn\'t look like a real answer. Try something a human might say.'],
    'keyboard row' => ['qwertyuiop', 'Keyboard mashing doesn\'t count. The deep sea can tell.'],
]);
