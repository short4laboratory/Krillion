<?php

use App\Enums\FishClass;
use App\Models\AcceptedAnswer;
use App\Models\Dive;
use App\Models\DiveAnswer;

beforeEach(function () {
    $this->questions = createQuestionBank();
    $this->dive = createDiveFor($this->questions);
    $this->withSession([Dive::SESSION_KEY => [$this->dive->id]]);
});

it('scores the most looked-up answer the minimum 10 points as a Schooler', function () {
    $this->post(route('dives.answers.store', $this->dive), ['answer' => 'vanilla'])
        ->assertRedirectToRoute('dives.show', $this->dive);

    $answer = DiveAnswer::sole();
    expect($answer->question_id)->toBe($this->questions[0]->id)
        ->and($answer->acceptedAnswer->label)->toBe('Vanilla')
        ->and($answer->position)->toBe(0)
        ->and($answer->answer)->toBe('vanilla')
        ->and($answer->points)->toBe(10)
        ->and($answer->fish_class)->toBe(FishClass::Schooler)
        ->and($answer->pageviews)->toBe(250_000)
        ->and($answer->prior_divers)->toBe(0)
        ->and($this->dive->fresh()->total_score)->toBe(10);
});

it('awards full points as a Snailfish for an answer a hundred times rarer than the favourite', function () {
    $this->post(route('dives.answers.store', $this->dive), ['answer' => 'Liechtenstein']);

    expect(DiveAnswer::sole())
        ->points->toBe(100)
        ->fish_class->toBe(FishClass::Snailfish)
        ->and($this->dive->fresh()->total_score)->toBe(100);
});

it('awards fewer points for an answer once other divers have given it', function () {
    DiveAnswer::factory()->count(3)->for($this->questions[0])->answering('Liechtenstein')->create();

    $this->post(route('dives.answers.store', $this->dive), ['answer' => 'Liechtenstein']);

    // 2.5 imaginary divers from Wikipedia plus 3 real ones: 45x rarer than the favourite instead of 100x.
    expect($this->dive->answers()->sole())
        ->points->toBe(90)
        ->prior_divers->toBe(3);
});

it('counts an alias or variant spelling as the answer it stands for', function (string $typed) {
    $this->post(route('dives.answers.store', $this->dive), ['answer' => $typed]);

    expect($this->dive->answers()->sole())
        ->acceptedAnswer->label->toBe('Bosnia and Herzegovina')
        ->answer_key->toBe('bosniaandherzegovina')
        ->points->toBe(70);
})->with(['Bosnia', 'BOSNIA & HERZEGOVINA', 'bosnia and herzegovina!']);

it('rejects an answer that is not on the answer key', function () {
    $this->post(route('dives.answers.store', $this->dive), ['answer' => 'Chocolate'])
        ->assertSessionHasErrors(['answer' => '“Chocolate” doesn\'t fit this one. Try another!'])
        ->assertSessionDoesntHaveErrors('suggestion');

    expect(DiveAnswer::count())->toBe(0);
});

it('rejects keyboard mashing with a gibberish message', function (string $mash) {
    $this->post(route('dives.answers.store', $this->dive), ['answer' => $mash])
        ->assertSessionHasErrors(['answer' => 'That looks like keyboard mashing. Try a real answer!']);

    expect(DiveAnswer::count())->toBe(0);
})->with(['asdfghjkl', 'zzzzzz', 'bcdfghk']);

it('rejects gibberish that slips past the mashing checks because it is not a correct answer', function () {
    $this->post(route('dives.answers.store', $this->dive), ['answer' => 'gkjasdhasd'])
        ->assertSessionHasErrors('answer');

    expect(DiveAnswer::count())->toBe(0);
});

it('suggests the answer a near miss probably meant if it gets past the instant check', function () {
    $this->post(route('dives.answers.store', $this->dive), ['answer' => 'Lichtenstein'])
        ->assertSessionHasErrors([
            'answer' => 'Did you mean “Liechtenstein”?',
            'suggestion' => 'Liechtenstein',
        ]);

    expect(DiveAnswer::count())->toBe(0);
});

it('shows the suggestion above the answer box, ready for Enter to accept it', function () {
    $this->followingRedirects()
        ->from(route('dives.show', $this->dive))
        ->post(route('dives.answers.store', $this->dive), ['answer' => 'Lichtenstein'])
        ->assertSee('data-suggestion="Liechtenstein"', escape: false)
        ->assertSeeInOrder(['Did you mean', 'Liechtenstein', 'Press Enter to use it', 'name="answer"'], escape: false)
        ->assertSee('value="Lichtenstein"', escape: false);
});

it('reveals the previous answer and descends to the next question', function () {
    $this->followingRedirects()
        ->post(route('dives.answers.store', $this->dive), ['answer' => 'bosnia'])
        ->assertOk()
        ->assertViewIs('dives.play')
        ->assertViewHas('descendFromMeters', 0)
        ->assertSee('“bosnia”', escape: false)
        ->assertSee('Counted as Bosnia and Herzegovina.')
        ->assertSee('Looked up 25K times on Wikipedia in the last 60 days, and no diver said it before you.')
        ->assertSee('The school\'s favourite answer: Vanilla.', escape: false)
        ->assertSee('data-descend-to=', escape: false)
        ->assertSee('Question 2 of 7')
        ->assertSee($this->questions[1]->prompt);
});

it('fills the rarity bar with the score, in the catch\'s rarity colour', function () {
    $this->followingRedirects()
        ->post(route('dives.answers.store', $this->dive), ['answer' => 'Liechtenstein'])
        ->assertSee('aria-label="Rarity: Mythic"', escape: false)
        ->assertSee('aria-valuenow="100"', escape: false)
        ->assertSee('style="width: 100%"', escape: false)
        ->assertSee('Mythic');
});

it('reels the depth meter\'s line out to a bobber in the last catch\'s rarity colour', function () {
    $this->followingRedirects()
        ->post(route('dives.answers.store', $this->dive), ['answer' => 'Pistachio'])
        ->assertSeeInOrder(['data-gauge-fill', 'reel-spin', 'data-gauge-marker', 'style="color: '.FishClass::Lanternfish->rarityColor().'"'], escape: false);
});

it('announces a new ocean zone when an answer sinks the diver into it', function () {
    $this->followingRedirects()
        ->post(route('dives.answers.store', $this->dive), ['answer' => 'Liechtenstein'])
        ->assertSee('Entering the')
        ->assertSee('Twilight Zone');
});

it('finishes the dive after the seventh answer and shows the results', function () {
    foreach (range(0, Dive::QUESTIONS_PER_DIVE - 2) as $position) {
        DiveAnswer::factory()->for($this->dive)->for($this->questions[$position])
            ->create(['position' => $position, 'points' => 50]);
    }
    $this->dive->update(['total_score' => 300]);

    $this->followingRedirects()
        ->post(route('dives.answers.store', $this->dive), ['answer' => 'Liechtenstein'])
        ->assertOk()
        ->assertViewIs('dives.catch')
        ->assertViewHas('descendFromMeters', Dive::depthForScore(300))
        ->assertSee('Your final catch')
        ->assertSeeInOrder(['data-auto-advance', 'data-seconds="5"', '“Liechtenstein”', 'Question 7 of 7', 'data-gauge-marker'], escape: false)
        ->assertSee('<meta http-equiv="refresh" content="5;url='.route('dives.show', $this->dive).'">', escape: false);

    // The final catch is shown once; coming back (or the countdown ending) shows the results.
    $this->get(route('dives.show', $this->dive))->assertViewIs('dives.results');

    $dive = $this->dive->fresh();
    expect($dive->isComplete())->toBeTrue()
        ->and($dive->total_score)->toBe(400)
        ->and($dive->answers()->count())->toBe(Dive::QUESTIONS_PER_DIVE);
});

it('scores an answer whose popularity has not been measured as a typical answer', function () {
    AcceptedAnswer::factory()->for($this->questions[0])->labelled('Mango')->unmeasured()->create();

    $this->post(route('dives.answers.store', $this->dive), ['answer' => 'Mango']);

    expect(DiveAnswer::sole())
        ->points->toBeGreaterThan(0)->toBeLessThan(100)
        ->pageviews->toBeNull();
});

describe('countdown', function () {
    beforeEach(function () {
        $this->freezeSecond();
        $this->dive->update(['question_started_at' => now()]);
    });

    it('stops the clock once the question is answered', function () {
        $this->travel(10)->seconds();

        $this->post(route('dives.answers.store', $this->dive), ['answer' => 'Pistachio']);

        expect($this->dive->fresh()->question_started_at)->toBeNull()
            ->and(DiveAnswer::sole()->timed_out)->toBeFalse();
    });

    it('records a miss worth nothing when time runs out with nothing typed', function () {
        $this->travel(Dive::SECONDS_PER_QUESTION)->seconds();

        $this->followingRedirects()
            ->post(route('dives.answers.store', $this->dive), ['answer' => '', 'timed_out' => '1'])
            ->assertOk()
            ->assertSee('Time\'s up!', escape: false)
            ->assertSee('Question 2 of 7');

        expect(DiveAnswer::sole())
            ->timed_out->toBeTrue()
            ->points->toBe(0)
            ->answer->toBeNull()
            ->answer_key->toBeNull()
            ->and($this->dive->fresh()->total_score)->toBe(0);
    });

    it('still scores a correct answer that was typed when time ran out', function () {
        $this->travel(Dive::SECONDS_PER_QUESTION)->seconds();

        $this->post(route('dives.answers.store', $this->dive), ['answer' => 'Pistachio', 'timed_out' => '1'])
            ->assertSessionHasNoErrors();

        expect(DiveAnswer::sole())
            ->timed_out->toBeFalse()
            ->answer->toBe('Pistachio')
            ->points->toBe(70);
    });

    it('autocorrects a near miss when time runs out instead of asking', function () {
        $this->travel(Dive::SECONDS_PER_QUESTION)->seconds();

        $this->post(route('dives.answers.store', $this->dive), ['answer' => 'Lichtenstein', 'timed_out' => '1'])
            ->assertSessionHasNoErrors();

        expect(DiveAnswer::sole())
            ->timed_out->toBeFalse()
            ->acceptedAnswer->label->toBe('Liechtenstein');
    });

    it('counts a wrong answer as a miss instead of showing an error when time runs out', function () {
        $this->travel(Dive::SECONDS_PER_QUESTION)->seconds();

        $this->post(route('dives.answers.store', $this->dive), ['answer' => 'Chocolate', 'timed_out' => '1'])
            ->assertSessionHasNoErrors();

        expect(DiveAnswer::sole()->timed_out)->toBeTrue();
    });

    it('treats an answer arriving after the deadline as a miss, whatever the browser claims', function () {
        $this->travel(Dive::SECONDS_PER_QUESTION + Dive::DEADLINE_GRACE_SECONDS + 1)->seconds();

        $this->post(route('dives.answers.store', $this->dive), ['answer' => 'Pistachio', 'timed_out' => '0'])
            ->assertSessionHasNoErrors();

        expect(DiveAnswer::sole())
            ->timed_out->toBeTrue()
            ->points->toBe(0);
    });

    it('accepts an answer that lands within the grace period', function () {
        $this->travel(Dive::SECONDS_PER_QUESTION + Dive::DEADLINE_GRACE_SECONDS)->seconds();

        $this->post(route('dives.answers.store', $this->dive), ['answer' => 'Pistachio']);

        expect(DiveAnswer::sole()->timed_out)->toBeFalse();
    });

    it('shows a miss on the results page', function () {
        foreach (range(0, Dive::QUESTIONS_PER_DIVE - 2) as $position) {
            DiveAnswer::factory()->for($this->dive)->for($this->questions[$position])->create(['position' => $position]);
        }
        $this->travel(Dive::SECONDS_PER_QUESTION)->seconds();

        $this->followingRedirects()
            ->post(route('dives.answers.store', $this->dive), ['timed_out' => '1'])
            ->assertViewIs('dives.catch')
            ->assertSee('Time\'s up!', escape: false);

        $this->get(route('dives.show', $this->dive))
            ->assertViewIs('dives.results')
            ->assertSee('Time\'s up. The fish got away', escape: false);
    });
});

it('forbids answering a dive started in another session', function () {
    $this->withSession([Dive::SESSION_KEY => []])
        ->post(route('dives.answers.store', $this->dive), ['answer' => 'Vanilla'])
        ->assertForbidden();

    expect(DiveAnswer::count())->toBe(0);
});

it('forbids answering a dive that is already finished', function () {
    $this->dive->update(['completed_at' => now()]);

    $this->post(route('dives.answers.store', $this->dive), ['answer' => 'Vanilla'])
        ->assertForbidden();

    expect(DiveAnswer::count())->toBe(0);
});

it('rejects a missing answer', function () {
    $this->post(route('dives.answers.store', $this->dive), ['answer' => ''])
        ->assertSessionHasErrors(['answer' => 'The answer field is required.']);

    expect(DiveAnswer::count())->toBe(0);
});
