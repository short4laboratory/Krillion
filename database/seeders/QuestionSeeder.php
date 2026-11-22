<?php

namespace Database\Seeders;

use App\Models\AcceptedAnswer;
use App\Models\Question;
use App\Services\AnswerMatcher;
use Illuminate\Database\Seeder;
use InvalidArgumentException;

/**
 * Seeds the question bank: knowledge questions with complete answer keys, so every answer can be
 * checked for correctness and scored by how rarely people would think of it.
 *
 * Popularity is not set here: run `php artisan krillion:fetch-popularity` afterwards to measure each
 * answer's Wikipedia page views. Questions no longer listed here are retired, not deleted, so old dives
 * keep their results. Safe to re-run.
 */
class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(AnswerMatcher $matcher): void
    {
        $countries = fn (array $names): array => collect($names)->mapWithKeys(function (string $name): array {
            if (! array_key_exists($name, WorldData::COUNTRIES)) {
                throw new InvalidArgumentException("Unknown country [{$name}] in the question bank.");
            }

            return [$name => [WorldData::COUNTRY_ARTICLES[$name] ?? null, WorldData::COUNTRIES[$name]]];
        })->all();
        $allCountries = array_keys(WorldData::COUNTRIES);
        $withoutAliases = fn (array $answers): array => array_map(fn (array $aliases): array => [null, $aliases], $answers);

        $questions = [
            'flag-with-red' => [
                'prompt' => 'Name a country whose flag has red in it.',
                'placeholder' => 'Skip the obvious ones…',
                'suffix' => '(country)',
                'answers' => $countries(array_diff($allCountries, WorldData::FLAGS_WITHOUT_RED)),
            ],
            'borders-exactly-two' => [
                'prompt' => 'Name a country that borders exactly two other countries.',
                'placeholder' => 'Count the neighbours carefully…',
                'suffix' => '(country)',
                'answers' => $countries(WorldData::BORDERS_EXACTLY_TWO),
            ],
            'landlocked-country' => [
                'prompt' => 'Name a landlocked country.',
                'placeholder' => 'No coastline allowed…',
                'suffix' => '(country)',
                'answers' => $countries(WorldData::LANDLOCKED),
            ],
            'european-capital' => [
                'prompt' => 'Name a capital city in Europe.',
                'placeholder' => 'Not Paris…',
                'suffix' => null,
                'answers' => WorldData::EUROPEAN_CAPITALS,
            ],
            'island-country' => [
                'prompt' => 'Name a country made up entirely of islands.',
                'placeholder' => 'Australia doesn\'t count…',
                'suffix' => '(country)',
                'answers' => $countries(WorldData::ISLAND_COUNTRIES),
            ],
            'chemical-element' => [
                'prompt' => 'Name a chemical element.',
                'placeholder' => 'Beyond oxygen…',
                'suffix' => '(element)',
                'answers' => TriviaData::ELEMENTS,
            ],
            'human-bone' => [
                'prompt' => 'Name a bone in the human body.',
                'placeholder' => 'Smaller than the femur…',
                'suffix' => '(bone)',
                'answers' => TriviaData::BONES,
            ],
            'constellation' => [
                'prompt' => 'Name a constellation.',
                'placeholder' => 'Look past Orion…',
                'suffix' => '(constellation)',
                'answers' => $withoutAliases(TriviaData::CONSTELLATIONS),
            ],
            'shakespeare-play' => [
                'prompt' => 'Name a play by William Shakespeare.',
                'placeholder' => 'Not Hamlet…',
                'suffix' => '(play)',
                'answers' => $withoutAliases(TriviaData::SHAKESPEARE_PLAYS),
            ],
            'greek-letter' => [
                'prompt' => 'Name a letter of the Greek alphabet.',
                'placeholder' => 'Somewhere between alpha and omega…',
                'suffix' => '(letter)',
                'answers' => TriviaData::GREEK_LETTERS,
            ],
            'flightless-bird' => [
                'prompt' => 'Name a bird that can\'t fly.',
                'placeholder' => 'Extinct ones count…',
                'suffix' => null,
                'answers' => TriviaData::FLIGHTLESS_BIRDS,
            ],
            'planet' => [
                'prompt' => 'Name a planet or dwarf planet in our solar system.',
                'placeholder' => 'Further out than Mars…',
                'suffix' => '(planet)',
                'answers' => TriviaData::PLANETS,
            ],
            'greek-god' => [
                'prompt' => 'Name an Olympian god or goddess of Greek mythology (or Hades).',
                'placeholder' => 'Not Zeus…',
                'suffix' => null,
                'answers' => $withoutAliases(TriviaData::GREEK_GODS),
            ],
            'norse-god' => [
                'prompt' => 'Name a god or goddess from Norse mythology.',
                'placeholder' => 'Beyond Thor and Loki…',
                'suffix' => null,
                'answers' => TriviaData::NORSE_GODS,
            ],
            'paris-2024-sport' => [
                'prompt' => 'Name a sport at the Paris 2024 Olympics.',
                'placeholder' => 'Something you rarely watch…',
                'suffix' => '(sport)',
                'answers' => TriviaData::PARIS_2024_SPORTS,
            ],
            'cloud-type' => [
                'prompt' => 'Name a type of cloud.',
                'placeholder' => 'Look up past cumulus…',
                'suffix' => 'cloud',
                'answers' => TriviaData::CLOUDS,
            ],
            'chinese-zodiac' => [
                'prompt' => 'Name an animal of the Chinese zodiac.',
                'placeholder' => 'Twelve to choose from…',
                'suffix' => '(zodiac)',
                'answers' => $withoutAliases(TriviaData::CHINESE_ZODIAC),
            ],
            'si-unit' => [
                'prompt' => 'Name an SI unit of measurement.',
                'placeholder' => 'Beyond metres and seconds…',
                'suffix' => '(unit)',
                'answers' => TriviaData::SI_UNITS,
            ],
            'eu-language' => [
                'prompt' => 'Name an official language of the European Union.',
                'placeholder' => 'Twenty-four to choose from…',
                'suffix' => 'language',
                'answers' => $withoutAliases(TriviaData::EU_LANGUAGES),
            ],
            'tarot-major-arcana' => [
                'prompt' => 'Name a card from the major arcana of the tarot.',
                'placeholder' => 'Twenty-two to choose from…',
                'suffix' => '(tarot card)',
                'answers' => $withoutAliases(TriviaData::TAROT_MAJOR_ARCANA),
            ],
            'asian-dish' => [
                'prompt' => 'Name an Asian dish.',
                'placeholder' => 'Beyond sushi and fried rice…',
                'suffix' => null,
                'answers' => FoodData::ASIAN_DISHES,
            ],
            'pasta' => [
                'prompt' => 'Name a type of pasta.',
                'placeholder' => 'Not spaghetti…',
                'suffix' => '(pasta)',
                'answers' => FoodData::PASTA,
            ],
            'cheese' => [
                'prompt' => 'Name a cheese.',
                'placeholder' => 'Past cheddar…',
                'suffix' => 'cheese',
                'answers' => FoodData::CHEESES,
            ],
            'spice' => [
                'prompt' => 'Name a spice.',
                'placeholder' => 'Deeper in the spice rack…',
                'suffix' => '(spice)',
                'answers' => FoodData::SPICES,
            ],
            'farm-animal' => [
                'prompt' => 'Name an animal you\'d find on a farm.',
                'placeholder' => 'Beyond the cow…',
                'suffix' => null,
                'answers' => AnimalData::FARM_ANIMALS,
            ],
            'zoo-animal' => [
                'prompt' => 'Name an animal you could see at a zoo.',
                'placeholder' => 'Not the lion…',
                'suffix' => null,
                'answers' => AnimalData::ZOO_ANIMALS,
            ],
            'cat-family' => [
                'prompt' => 'Name a member of the cat family.',
                'placeholder' => 'Smaller than a lion…',
                'suffix' => null,
                'answers' => AnimalData::CAT_FAMILY,
            ],
            'marsupial' => [
                'prompt' => 'Name a marsupial.',
                'placeholder' => 'Beyond the kangaroo…',
                'suffix' => null,
                'answers' => AnimalData::MARSUPIALS,
            ],
        ];

        foreach ($questions as $slug => $definition) {
            $question = Question::updateOrCreate(['slug' => $slug], [
                'prompt' => $definition['prompt'],
                'placeholder' => $definition['placeholder'],
                'article_suffix' => $definition['suffix'],
                'retired_at' => null,
            ]);

            $keys = [];

            foreach ($definition['answers'] as $label => [$article, $aliases]) {
                $key = $matcher->normalize($label);
                $keys[] = $key;
                $aliasKeys = collect($aliases)
                    ->map(fn (string $alias): string => $matcher->normalize($alias))
                    ->reject(fn (string $aliasKey): bool => $aliasKey === $key)
                    ->unique()
                    ->values()
                    ->all();

                AcceptedAnswer::updateOrCreate(
                    ['question_id' => $question->id, 'key' => $key],
                    ['label' => $label, 'article' => $article, 'alias_keys' => $aliasKeys],
                );
            }

            $question->acceptedAnswers()->whereNotIn('key', $keys)->delete();
        }

        Question::query()
            ->whereNotIn('slug', array_keys($questions))
            ->active()
            ->update(['retired_at' => now()]);

        $this->command?->info('Now run `php artisan krillion:fetch-popularity` to measure how often each answer is looked up.');
    }
}
