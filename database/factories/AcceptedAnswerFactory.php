<?php

namespace Database\Factories;

use App\Models\AcceptedAnswer;
use App\Models\Question;
use App\Services\AnswerMatcher;
use App\Services\WikipediaPopularity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AcceptedAnswer>
 */
class AcceptedAnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $label = ucfirst(fake()->unique()->word());
        $pageviews = fake()->numberBetween(1_000, 500_000);

        return [
            'question_id' => Question::factory(),
            'key' => app(AnswerMatcher::class)->normalize($label),
            'label' => $label,
            'article' => null,
            'alias_keys' => [],
            'resolved_article' => $label,
            'pageviews' => $pageviews,
            'dictionary_frequency' => 0.0,
            'weight' => WikipediaPopularity::weightFor($pageviews, 0.0),
            'popularity_fetched_at' => now(),
        ];
    }

    /**
     * A specific answer, optionally with aliases.
     *
     * @param  list<string>  $aliases
     */
    public function labelled(string $label, array $aliases = []): static
    {
        $matcher = app(AnswerMatcher::class);

        return $this->state(fn (): array => [
            'label' => $label,
            'key' => $matcher->normalize($label),
            'resolved_article' => $label,
            'alias_keys' => array_map(fn (string $alias): string => $matcher->normalize($alias), $aliases),
        ]);
    }

    /**
     * Looked up this many times on Wikipedia, with no dictionary boost.
     */
    public function withPageviews(int $pageviews): static
    {
        return $this->state(fn (): array => [
            'pageviews' => $pageviews,
            'dictionary_frequency' => 0.0,
            'weight' => WikipediaPopularity::weightFor($pageviews, 0.0),
            'popularity_fetched_at' => now(),
        ]);
    }

    /**
     * Not measured by `krillion:fetch-popularity` yet.
     */
    public function unmeasured(): static
    {
        return $this->state(fn (): array => [
            'resolved_article' => null,
            'pageviews' => null,
            'dictionary_frequency' => null,
            'weight' => null,
            'popularity_fetched_at' => null,
        ]);
    }
}
