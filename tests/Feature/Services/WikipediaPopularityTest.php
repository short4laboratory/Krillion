<?php

use App\Services\WikipediaPopularity;
use Illuminate\Http\Client\Request;

it('sums 60 days of page views and follows redirects', function () {
    fakeWikipedia(['France' => 567_435, 'Czechia' => ['redirect' => 'Czech Republic'], 'Czech Republic' => 373_285]);

    $results = app(WikipediaPopularity::class)->pageviews(['France', 'Czechia']);

    expect($results)->toBe([
        'France' => ['title' => 'France', 'pageviews' => 567_435],
        'Czechia' => ['title' => 'Czech Republic', 'pageviews' => 373_285],
    ]);
    Http::assertSent(fn (Request $request): bool => str_contains(urldecode($request->url()), 'titles=France|Czechia')
        && str_contains($request->url(), 'pvipdays=60'));
});

it('treats missing articles and disambiguation pages as unusable', function () {
    fakeWikipedia(['Mercury' => 'disambiguation']);

    expect(app(WikipediaPopularity::class)->pageviews(['Mercury', 'Nosuchpage']))
        ->toBe(['Mercury' => null, 'Nosuchpage' => null]);
});

it('pauses for as long as Wikipedia asks when rate limited', function () {
    Http::fake(['en.wikipedia.org/*' => Http::response('Too many requests', 429, ['Retry-After' => '47'])]);
    $popularity = app(WikipediaPopularity::class);

    expect($popularity->pageviews(['France']))->toBeNull()
        ->and($popularity->pageviews(['Spain']))->toBeNull()
        ->and($popularity->backoffUntil()?->diffInSeconds(now(), true))->toEqualWithDelta(47, 2);
    Http::assertSentCount(1);
});

it('refuses more titles than one request allows', function () {
    app(WikipediaPopularity::class)->pageviews(array_map(fn (int $n): string => "Title {$n}", range(1, 51)));
})->throws(InvalidArgumentException::class);

it('reads word frequency from Datamuse', function () {
    fakeWikipedia(frequencies: ['iron' => 42.5]);
    $popularity = app(WikipediaPopularity::class);

    expect($popularity->dictionaryFrequency('Iron'))->toBe(42.5)
        ->and($popularity->dictionaryFrequency('Moscovium'))->toBe(0.0);
});

it('boosts everyday words in the combined weight', function () {
    expect(WikipediaPopularity::weightFor(1_000, 0.0))->toBe(1000.0)
        ->and(WikipediaPopularity::weightFor(1_000, 9.0))->toBe(2000.0);
});
