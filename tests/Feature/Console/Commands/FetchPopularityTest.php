<?php

use App\Models\AcceptedAnswer;
use App\Models\Question;
use App\Services\WikipediaPopularity;
use Illuminate\Support\Sleep;

beforeEach(function () {
    Sleep::fake();
    $this->question = Question::factory()->create(['article_suffix' => '(constellation)']);
});

it('measures unmeasured answers, trying the explicit article, then the suffixed label, then the bare label', function () {
    $orion = AcceptedAnswer::factory()->for($this->question)->labelled('Orion')->unmeasured()->create();
    $cancer = AcceptedAnswer::factory()->for($this->question)->labelled('Cancer')->unmeasured()->create();
    $lyra = AcceptedAnswer::factory()->for($this->question)->labelled('Lyra')->unmeasured()->create(['article' => 'Lyra (stars)']);
    $measured = AcceptedAnswer::factory()->for($this->question)->labelled('Leo')->withPageviews(9_000)->create();
    fakeWikipedia(
        ['Orion (constellation)' => 40_000, 'Cancer (constellation)' => 11_162, 'Lyra' => 8_000, 'Cancer' => 900_000],
        ['orion' => 4.0],
    );

    $this->artisan('krillion:fetch-popularity')->assertSuccessful();

    expect($orion->fresh())
        ->resolved_article->toBe('Orion (constellation)')
        ->pageviews->toBe(40_000)
        ->weight->toEqualWithDelta(40_000.0, 0.001)
        ->popularity_fetched_at->not->toBeNull()
        ->and($cancer->fresh()->pageviews)->toBe(11_162)
        ->and($lyra->fresh()->resolved_article)->toBe('Lyra')
        ->and($measured->fresh()->pageviews)->toBe(9_000);
});

it('boosts everyday words only when the answer\'s own name is its article', function () {
    $cinnamon = AcceptedAnswer::factory()->for($this->question)->labelled('Cinnamon')->unmeasured()->create();
    $quark = AcceptedAnswer::factory()->for($this->question)->labelled('Quark')->unmeasured()->create(['article' => 'Quark (dairy product)']);
    fakeWikipedia(['Cinnamon (constellation)' => 'missing', 'Cinnamon' => 30_000, 'Quark (dairy product)' => 40_000], ['cinnamon' => 9.0, 'quark' => 9.0]);

    $this->artisan('krillion:fetch-popularity')->assertSuccessful();

    expect($cinnamon->fresh())
        ->dictionary_frequency->toBe(9.0)
        ->weight->toEqualWithDelta(WikipediaPopularity::weightFor(30_000, 9.0), 0.001)
        ->and($quark->fresh())
        ->dictionary_frequency->toBe(0.0)
        ->weight->toEqualWithDelta(40_000.0, 0.001);
});

it('leaves an answer unmeasured when none of its titles is a usable article', function () {
    $draco = AcceptedAnswer::factory()->for($this->question)->labelled('Draco')->unmeasured()->create();
    fakeWikipedia(['Draco' => 'disambiguation']);

    $this->artisan('krillion:fetch-popularity')
        ->expectsOutputToContain('no Wikipedia article found for Draco')
        ->assertSuccessful();

    expect($draco->fresh()->pageviews)->toBeNull();
});

it('skips retired questions', function () {
    $retired = Question::factory()->retired()->create();
    AcceptedAnswer::factory()->for($retired)->labelled('Banana')->unmeasured()->create();

    $this->artisan('krillion:fetch-popularity')
        ->expectsOutputToContain('already has a popularity measurement')
        ->assertSuccessful();
});

it('re-measures everything with --fresh', function () {
    $leo = AcceptedAnswer::factory()->for($this->question)->labelled('Leo')->withPageviews(9_000)->create();
    fakeWikipedia(['Leo (constellation)' => 12_000]);

    $this->artisan('krillion:fetch-popularity', ['--fresh' => true])->assertSuccessful();

    expect($leo->fresh()->pageviews)->toBe(12_000);
});

it('gives up with an error when Wikipedia keeps rate limiting', function () {
    AcceptedAnswer::factory()->for($this->question)->labelled('Orion')->unmeasured()->create();
    Http::fake(['*' => Http::response('Too many requests', 429, ['Retry-After' => '30'])]);

    $this->artisan('krillion:fetch-popularity')
        ->expectsOutputToContain('could not be reached')
        ->assertFailed();

    Sleep::assertSlept(fn ($duration): bool => $duration->totalSeconds >= 29, times: 4);
});
