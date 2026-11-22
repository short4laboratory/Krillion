<?php

use App\Models\Dive;
use App\Models\DiveAnswer;

beforeEach(function () {
    $this->questions = createQuestionBank();
    $this->dive = createDiveFor($this->questions);
    $this->withSession([Dive::SESSION_KEY => [$this->dive->id]]);
});

it('accepts an answer on the answer key, including aliases', function (string $typed) {
    $this->postJson(route('dives.answer-checks.store', $this->dive), ['answer' => $typed])
        ->assertOk()
        ->assertExactJson(['status' => 'accepted', 'suggestion' => null, 'message' => '']);
})->with(['Vanilla', 'bosnia']);

it('suggests a correction for a near miss', function () {
    $this->postJson(route('dives.answer-checks.store', $this->dive), ['answer' => 'Lichtenstein'])
        ->assertOk()
        ->assertExactJson(['status' => 'suggestion', 'suggestion' => 'Liechtenstein', 'message' => 'Did you mean “Liechtenstein”?']);
});

it('rejects a wrong answer with the message to show above the box', function (string $typed, string $message) {
    $this->postJson(route('dives.answer-checks.store', $this->dive), ['answer' => $typed])
        ->assertOk()
        ->assertExactJson(['status' => 'rejected', 'suggestion' => null, 'message' => $message]);
})->with([
    'not on the key' => ['Chocolate', '“Chocolate” doesn\'t fit this one. Try another!'],
    'keyboard mashing' => ['asdfghjkl', 'That looks like keyboard mashing. Try a real answer!'],
]);

it('checks against the current question as the dive progresses', function () {
    DiveAnswer::factory()->for($this->dive)->for($this->questions[0])->create(['position' => 0]);
    $this->questions[1]->acceptedAnswers()->where('label', 'Vanilla')->delete();

    $this->postJson(route('dives.answer-checks.store', $this->dive), ['answer' => 'Vanilla'])
        ->assertJsonPath('status', 'rejected');
});

it('records nothing and leaves the clock running', function () {
    $this->freezeSecond();
    $this->dive->update(['question_started_at' => now()->subSeconds(5)]);

    $this->postJson(route('dives.answer-checks.store', $this->dive), ['answer' => 'Vanilla'])->assertOk();

    expect(DiveAnswer::count())->toBe(0)
        ->and($this->dive->fresh()->secondsRemaining())->toBe(20);
});

it('requires an answer to check', function () {
    $this->postJson(route('dives.answer-checks.store', $this->dive), ['answer' => ''])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['answer' => 'The answer field is required.']);
});

it('forbids checking answers for a dive started in another session', function () {
    $this->withSession([Dive::SESSION_KEY => []])
        ->postJson(route('dives.answer-checks.store', $this->dive), ['answer' => 'Vanilla'])
        ->assertForbidden();
});

it('forbids checking answers once the dive is over', function () {
    $this->dive->update(['completed_at' => now()]);

    $this->postJson(route('dives.answer-checks.store', $this->dive), ['answer' => 'Vanilla'])
        ->assertForbidden();
});
