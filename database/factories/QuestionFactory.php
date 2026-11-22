<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $topic = fake()->unique()->words(2, true);

        return [
            'slug' => str($topic)->slug()->toString(),
            'prompt' => "Name a {$topic}.",
            'placeholder' => 'Something unusual…',
            'article_suffix' => null,
            'retired_at' => null,
        ];
    }

    /**
     * A question taken out of rotation (kept only for old dives' results).
     */
    public function retired(): static
    {
        return $this->state(fn (): array => ['retired_at' => now()]);
    }
}
