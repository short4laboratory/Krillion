<?php

use App\Models\AcceptedAnswer;
use App\Models\Dive;
use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind different classes or traits.
|
*/

pest()->extend(TestCase::class)
    ->use(LazilyRefreshDatabase::class)
    ->beforeEach(fn () => Http::preventStrayRequests())
    ->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

/**
 * Create a full dive's worth of questions, all sharing one answer key:
 *
 * - Vanilla: 250,000 Wikipedia views (the favourite, worth 0 points)
 * - Bosnia and Herzegovina (alias "bosnia"): 25,000 views (10x rarer, 50 points)
 * - Pistachio: 20,000 views
 * - Liechtenstein: 2,500 views (100x rarer, 100 points)
 *
 * @return Collection<int, Question>
 */
function createQuestionBank(int $count = Dive::QUESTIONS_PER_DIVE): Collection
{
    return Question::factory()->count($count)->create()->each(function (Question $question): void {
        AcceptedAnswer::factory()->for($question)->labelled('Vanilla')->withPageviews(250_000)->create();
        AcceptedAnswer::factory()->for($question)->labelled('Bosnia and Herzegovina', ['bosnia'])->withPageviews(25_000)->create();
        AcceptedAnswer::factory()->for($question)->labelled('Pistachio')->withPageviews(20_000)->create();
        AcceptedAnswer::factory()->for($question)->labelled('Liechtenstein')->withPageviews(2_500)->create();
    });
}

/**
 * Create an in-progress dive over the given questions.
 *
 * @param  Illuminate\Support\Collection<int, Question>  $questions
 */
function createDiveFor(Illuminate\Support\Collection $questions): Dive
{
    return Dive::factory()->create(['question_ids' => $questions->pluck('id')->all()]);
}

/**
 * Fake Wikipedia's page-view API and Datamuse.
 *
 * `$articles` maps a title to its 60-day views, or to 'missing', 'disambiguation', or ['redirect' => 'Other title'].
 * Titles not listed are missing. `$frequencies` maps a lowercase word to its Datamuse frequency.
 *
 * @param  array<string, int|string|array{redirect: string}>  $articles
 * @param  array<string, float>  $frequencies
 */
function fakeWikipedia(array $articles = [], array $frequencies = []): void
{
    $query = function (Request $request): array {
        parse_str((string) parse_url($request->url(), PHP_URL_QUERY), $parameters);

        return $parameters;
    };

    Http::fake([
        'en.wikipedia.org/*' => function (Request $request) use ($articles, $query) {
            $redirects = [];
            $pages = [];

            foreach (explode('|', $query($request)['titles'] ?? '') as $title) {
                $entry = $articles[$title] ?? 'missing';

                if (is_array($entry)) {
                    $redirects[] = ['from' => $title, 'to' => $entry['redirect']];
                    $title = $entry['redirect'];
                    $entry = $articles[$title] ?? 'missing';
                }

                $pages[] = match ($entry) {
                    'missing' => ['title' => $title, 'missing' => true],
                    'disambiguation' => ['title' => $title, 'pageprops' => ['disambiguation' => ''], 'pageviews' => ['2026-11-01' => 10]],
                    default => ['title' => $title, 'pageprops' => [], 'pageviews' => ['2026-11-01' => $entry - 1, '2026-11-02' => 1, '2026-11-03' => null]],
                };
            }

            return Http::response(['query' => ['redirects' => $redirects, 'pages' => $pages]]);
        },
        'api.datamuse.com/*' => function (Request $request) use ($frequencies, $query) {
            $word = Str::lower($query($request)['sp'] ?? '');

            return Http::response(isset($frequencies[$word]) ? [['word' => $word, 'score' => 1, 'tags' => ["f:{$frequencies[$word]}"]]] : []);
        },
    ]);
}
