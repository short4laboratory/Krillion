<?php

use App\Models\AcceptedAnswer;
use App\Models\Question;
use App\Services\AnswerMatcher;

beforeEach(function () {
    $this->question = Question::factory()->create();
    foreach (['Liechtenstein' => [], 'Kyrgyzstan' => [], 'Niger' => [], 'Nigeria' => [], 'Iraq' => [], 'Czech Republic' => ['czechia']] as $label => $aliases) {
        AcceptedAnswer::factory()->for($this->question)->labelled($label, $aliases)->create();
    }
    $this->matcher = app(AnswerMatcher::class);
});

it('normalizes trivially different answers to the same key', function (string $typed, string $key) {
    expect($this->matcher->normalize($typed))->toBe($key);
})->with([
    'case and spacing' => ['  Costa   RICA ', 'costarica'],
    'ampersand' => ['Bosnia & Herzegovina', 'bosniaandherzegovina'],
    'punctuation' => ['Guinea-Bissau!', 'guineabissau'],
    'accents' => ['São Tomé', 'saotome'],
    'leading article' => ['The Gambia', 'gambia'],
    'plurals' => ['Philippines', 'philippine'],
]);

it('matches names and aliases exactly', function (string $typed, string $label) {
    expect($this->matcher->match($this->question, $typed)?->label)->toBe($label);
})->with([
    ['niger', 'Niger'],
    ['NIGERIA', 'Nigeria'],
    ['Czechia', 'Czech Republic'],
]);

it('does not match answers that are not on the key', function () {
    expect($this->matcher->match($this->question, 'Iran'))->toBeNull();
});

it('suggests the answer a typo or sound-alike spelling meant', function (string $typed, string $label) {
    expect($this->matcher->suggest($this->question, $typed)?->label)->toBe($label);
})->with([
    'missing letter' => ['Lichtenstein', 'Liechtenstein'],
    'swapped letters' => ['Liechtenstien', 'Liechtenstein'],
    'phonetic spelling' => ['Kirgistan', 'Kyrgyzstan'],
    'one letter off' => ['Iraqq', 'Iraq'],
]);

it('does not suggest anything for answers that are nowhere close', function (string $typed) {
    expect($this->matcher->suggest($this->question, $typed))->toBeNull();
})->with(['Brazil', 'gkjasdhasd', 'ab']);
