<?php

use App\Enums\FishClass;
use App\Models\Dive;
use App\Models\DiveAnswer;
use App\Models\Question;

describe('index', function () {
    it('ranks finished dives deepest first and leaves out unfinished ones', function () {
        Dive::factory()->completed(120)->create(['player_name' => 'Shallow Sam']);
        Dive::factory()->completed(610)->create(['player_name' => 'Deep Dana']);
        Dive::factory()->create(['player_name' => 'Still Diving', 'total_score' => 690]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSeeInOrder(['Deep Dana', 'Shallow Sam'])
            ->assertDontSee('Still Diving');
    });
});

describe('store', function () {
    it('starts a dive with seven distinct questions owned by this session', function () {
        createQuestionBank(10);

        $response = $this->post(route('dives.store'), ['player_name' => '  Captain   Nemo ']);

        $dive = Dive::sole();
        $response->assertRedirectToRoute('dives.show', $dive)
            ->assertSessionHas(Dive::SESSION_KEY, [$dive->id]);
        expect($dive->player_name)->toBe('Captain Nemo')
            ->and($dive->question_ids)->toHaveCount(Dive::QUESTIONS_PER_DIVE)
            ->and(array_unique($dive->question_ids))->toHaveCount(Dive::QUESTIONS_PER_DIVE)
            ->and($dive->total_score)->toBe(0);
    });

    it('never asks retired questions', function () {
        $active = createQuestionBank();
        Question::factory()->count(5)->retired()->create();

        $this->post(route('dives.store'));

        expect(Dive::sole()->question_ids)->toEqualCanonicalizing($active->pluck('id')->all());
    });

    it('names the diver Anonymous Krill when no name is given', function () {
        createQuestionBank();

        $this->post(route('dives.store'));

        expect(Dive::sole()->player_name)->toBe('Anonymous Krill');
    });

    it('rejects a diver name longer than 24 characters', function () {
        createQuestionBank();

        $this->post(route('dives.store'), ['player_name' => str_repeat('a', 25)])
            ->assertSessionHasErrors(['player_name' => 'The player name field must not be greater than 24 characters.']);

        expect(Dive::count())->toBe(0);
    });

    it('returns 503 when fewer than seven questions are seeded', function () {
        createQuestionBank(Dive::QUESTIONS_PER_DIVE - 1);

        $this->post(route('dives.store'))->assertServiceUnavailable();

        expect(Dive::count())->toBe(0);
    });
});

describe('show', function () {
    it('asks the first question on the boat, ready to cast', function () {
        $questions = createQuestionBank();
        $dive = createDiveFor($questions);

        $this->withSession([Dive::SESSION_KEY => [$dive->id]])
            ->get(route('dives.show', $dive))
            ->assertOk()
            ->assertViewIs('dives.cast')
            ->assertSee('data-boat-scene', escape: false)
            ->assertSee('data-cast', escape: false)
            ->assertSee('Question 1 of 7')
            ->assertSee($questions[0]->prompt);
    });

    it('shows later questions underwater', function () {
        $questions = createQuestionBank();
        $dive = createDiveFor($questions);
        DiveAnswer::factory()->for($dive)->for($questions[0])->create(['position' => 0]);

        $this->withSession([Dive::SESSION_KEY => [$dive->id]])
            ->get(route('dives.show', $dive))
            ->assertOk()
            ->assertViewIs('dives.play')
            ->assertDontSee('data-cast', escape: false)
            ->assertSee('Question 2 of 7')
            ->assertSee($questions[1]->prompt);
    });

    it('starts a 25 second countdown when a question is first shown', function () {
        $this->freezeSecond();
        $dive = createDiveFor(createQuestionBank());

        $this->withSession([Dive::SESSION_KEY => [$dive->id]])
            ->get(route('dives.show', $dive))
            ->assertSee('data-seconds-remaining="25"', escape: false);

        expect($dive->fresh()->question_started_at->equalTo(now()))->toBeTrue();
    });

    it('keeps counting down when the question page is reloaded', function () {
        $this->freezeSecond();
        $dive = createDiveFor(createQuestionBank());
        $this->withSession([Dive::SESSION_KEY => [$dive->id]])->get(route('dives.show', $dive));

        $this->travel(9)->seconds();

        $this->get(route('dives.show', $dive))
            ->assertSee('data-seconds-remaining="16"', escape: false)
            ->assertSee('data-urgency="calm"', escape: false);
    });

    it('shows the countdown as urgent in the last five seconds', function () {
        $this->freezeSecond();
        $dive = createDiveFor(createQuestionBank());
        $dive->update(['question_started_at' => now()->subSeconds(21)]);

        $this->withSession([Dive::SESSION_KEY => [$dive->id]])
            ->get(route('dives.show', $dive))
            ->assertSee('data-seconds-remaining="4"', escape: false)
            ->assertSee('data-urgency="critical"', escape: false);
    });

    it('forbids viewing a dive in progress from another session', function () {
        $dive = createDiveFor(createQuestionBank());

        $this->get(route('dives.show', $dive))->assertForbidden();
    });

    it('shows finished results to anyone, with depth, fish class and the most common answers', function () {
        $questions = createQuestionBank();
        $dive = createDiveFor($questions);
        $dive->update(['total_score' => 700, 'completed_at' => now()]);
        foreach ($questions as $position => $question) {
            DiveAnswer::factory()->for($dive)->for($question)->answering('Buttermilk')
                ->create(['position' => $position, 'points' => 100, 'fish_class' => FishClass::Snailfish]);
        }

        $this->get(route('dives.show', $dive))
            ->assertOk()
            ->assertViewIs('dives.results')
            ->assertSee('10,935')
            ->assertSee('The deepest point in any ocean.')
            ->assertSee('Snailfish')
            ->assertSee('“Buttermilk”', escape: false)
            ->assertSee('The school said: Vanilla, Bosnia and Herzegovina, Pistachio.')
            ->assertSee('Take the plunge yourself')
            ->assertDontSee('data-descend-to=', escape: false);
    });

    it('still shows the results of a dive whose questions have since been retired', function () {
        $questions = Question::factory()->count(Dive::QUESTIONS_PER_DIVE)->retired()->create();
        $dive = createDiveFor($questions);
        $dive->update(['total_score' => 70, 'completed_at' => now()]);
        foreach ($questions as $position => $question) {
            DiveAnswer::factory()->for($dive)->for($question)->answering('Banana')
                ->create(['position' => $position, 'points' => 10, 'pageviews' => null, 'encyclopedia_hits' => 4739]);
        }

        $this->get(route('dives.show', $dive))
            ->assertOk()
            ->assertSee('“Banana”', escape: false)
            ->assertSee('4,739 encyclopedia articles pair it with this question');
    });
});
