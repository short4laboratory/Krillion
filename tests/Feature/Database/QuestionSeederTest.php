<?php

use App\Models\AcceptedAnswer;
use App\Models\Question;
use App\Services\AnswerMatcher;
use Database\Seeders\QuestionSeeder;

beforeEach(function () {
    $this->seed(QuestionSeeder::class);
});

it('seeds every question with an answer key', function () {
    $questions = Question::query()->active()->withCount('acceptedAnswers')->get();

    expect($questions)->toHaveCount(28)
        ->and($questions->every(fn (Question $question): bool => $question->accepted_answers_count >= 12))->toBeTrue();
});

it('keeps location questions to a quarter of the bank, with nothing about a single country', function () {
    $slugs = Question::query()->active()->pluck('slug');
    $locationQuestions = $slugs->intersect(['flag-with-red', 'borders-exactly-two', 'landlocked-country', 'island-country', 'european-capital']);

    expect($locationQuestions)->toHaveCount(5)
        ->and($slugs->filter(fn (string $slug): bool => str_starts_with($slug, 'us-')))->toBeEmpty();
});

it('never lets an alias of one answer match a different answer on the same key', function () {
    $collisions = AcceptedAnswer::query()->get()->groupBy('question_id')->flatMap(function ($answers) {
        $keys = $answers->pluck('key');

        return $answers->flatMap(fn (AcceptedAnswer $answer): array => collect($answer->alias_keys)
            ->intersect($keys)
            ->map(fn (string $alias): string => "{$answer->label} ← {$alias}")
            ->all());
    });

    expect($collisions->all())->toBe([]);
});

// Checked in one test each (rather than a dataset) so the 1,000+ answer bank is only seeded once.
it('accepts the obvious and the obscure answers, including nicknames', function () {
    $cases = [
        ['island-country', 'Nauru', 'Nauru'],
        ['greek-letter', 'omicron', 'Omicron'],
        ['flightless-bird', 'emperor penguin', 'Penguin'],
        ['flightless-bird', 'kakapo', 'Kākāpō'],
        ['planet', 'Makemake', 'Makemake'],
        ['greek-god', 'Hephaestus', 'Hephaestus'],
        ['norse-god', 'Njord', 'Njörðr'],
        ['norse-god', 'Baldur', 'Baldr'],
        ['paris-2024-sport', 'soccer', 'Football'],
        ['paris-2024-sport', 'breakdancing', 'Breaking'],
        ['cloud-type', 'thunderhead', 'Cumulonimbus'],
        ['cloud-type', 'Noctilucent', 'Noctilucent'],
        ['chinese-zodiac', 'sheep', 'Goat'],
        ['si-unit', 'meter', 'Metre'],
        ['si-unit', 'Katal', 'Katal'],
        ['eu-language', 'Slovenian', 'Slovene'],
        ['tarot-major-arcana', 'Hanged Man', 'The Hanged Man'],
        ['tarot-major-arcana', 'Judgment', 'Judgement'],
        ['asian-dish', 'pho', 'Pho'],
        ['asian-dish', 'Korean BBQ', 'Samgyeopsal'],
        ['asian-dish', 'doner kebab', 'Kebab'],
        ['pasta', 'angel hair', 'Capellini'],
        ['pasta', 'bow ties', 'Farfalle'],
        ['cheese', 'Swiss', 'Emmental'],
        ['cheese', 'goat cheese', 'Chèvre'],
        ['spice', 'szechuan pepper', 'Sichuan pepper'],
        ['farm-animal', 'piglet', 'Pig'],
        ['farm-animal', 'rooster', 'Chicken'],
        ['zoo-animal', 'hippo', 'Hippopotamus'],
        ['zoo-animal', 'Okapi', 'Okapi'],
        ['cat-family', 'manul', 'Pallas\'s cat'],
        ['cat-family', 'house cat', 'Domestic cat'],
        ['marsupial', 'Tasmanian tiger', 'Thylacine'],
        ['marsupial', 'Numbat', 'Numbat'],
    ];

    $mismatches = collect($cases)->reject(fn (array $case): bool => matchOnKey($case[0], $case[1]) === $case[2]);

    expect($mismatches->all())->toBe([]);
});

it('rejects answers that are not on the key', function () {
    $cases = [
        ['island-country', 'Australia'],
        ['flightless-bird', 'Eagle'],
        ['planet', 'Moon'],
        ['greek-god', 'Jupiter'],
        ['paris-2024-sport', 'Baseball'],
        ['si-unit', 'Litre'],
        ['eu-language', 'Russian'],
        ['asian-dish', 'Lasagne'],
        ['pasta', 'Ramen'],
        ['farm-animal', 'Lion'],
        ['cat-family', 'Hyena'],
        ['marsupial', 'Panda'],
    ];

    $accepted = collect($cases)->filter(fn (array $case): bool => matchOnKey($case[0], $case[1]) !== null);

    expect($accepted->all())->toBe([]);
});

function matchOnKey(string $slug, string $typed): ?string
{
    return app(AnswerMatcher::class)->match(Question::query()->where('slug', $slug)->sole(), $typed)?->label;
}

it('retires questions that are no longer in the bank', function () {
    $old = Question::factory()->create(['slug' => 'ice-cream-flavor']);

    $this->seed(QuestionSeeder::class);

    expect($old->fresh()->retired_at)->not->toBeNull();
});
