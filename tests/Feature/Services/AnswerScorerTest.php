<?php

use App\Models\AcceptedAnswer;
use App\Models\DiveAnswer;
use App\Models\Question;
use App\Services\AnswerScorer;

it('scores in steps of ten, from 10 for the favourite to 100 for an answer a hundred times rarer', function (float $timesGiven, int $points) {
    expect(app(AnswerScorer::class)->pointsFor($timesGiven, 250))->toBe($points);
})->with([
    'the favourite' => [250, 10],
    'twice as rare' => [125, 40],
    'ten times rarer' => [25, 70],
    'thirty times rarer' => [8.3, 80],
    'fifty times rarer' => [5, 90],
    'a hundred times rarer' => [2.5, 100],
    'rarer still' => [0.01, 100],
]);

it('lets the crowd overtake the most looked-up answer', function () {
    $question = Question::factory()->create();
    $vanilla = AcceptedAnswer::factory()->for($question)->labelled('Vanilla')->withPageviews(100_000)->create();
    $pistachio = AcceptedAnswer::factory()->for($question)->labelled('Pistachio')->withPageviews(1_000)->create();
    DiveAnswer::factory()->count(AnswerScorer::REFERENCE_TOP_DIVERS + 50)->for($question)->answering('Pistachio')->create();

    $scorer = app(AnswerScorer::class);

    expect($scorer->score($question, $pistachio)->points)->toBe(AnswerScorer::MIN_CORRECT_POINTS)
        ->and($scorer->score($question, $vanilla)->points)->toBeGreaterThan(AnswerScorer::MIN_CORRECT_POINTS);
});

it('ranks the most common answers by Wikipedia popularity plus crowd answers', function () {
    $question = Question::factory()->create();
    foreach (['Vanilla' => 30_000, 'Pistachio' => 20_000, 'Mango' => 10_000] as $label => $pageviews) {
        AcceptedAnswer::factory()->for($question)->labelled($label)->withPageviews($pageviews)->create();
    }
    DiveAnswer::factory()->count(100)->for($question)->answering('Pistachio')->create();

    $ranked = app(AnswerScorer::class)->mostCommonAnswers(collect([$question]), 2);

    expect($ranked)->toBe([$question->id => ['Pistachio', 'Vanilla']]);
});
