<?php

namespace Database\Factories;

use App\Enums\FishClass;
use App\Models\Dive;
use App\Models\DiveAnswer;
use App\Models\Question;
use App\Services\AnswerMatcher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DiveAnswer>
 */
class DiveAnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $answer = ucfirst(fake()->word());
        $points = fake()->numberBetween(0, 100);

        return [
            'dive_id' => Dive::factory(),
            'question_id' => Question::factory(),
            'position' => 0,
            'answer' => $answer,
            'answer_key' => app(AnswerMatcher::class)->normalize($answer),
            'points' => $points,
            'pageviews' => fake()->numberBetween(1_000, 500_000),
            'prior_divers' => 0,
            'fish_class' => FishClass::fromPoints($points),
        ];
    }

    /**
     * Use a specific answer text, deriving its normalized key.
     */
    public function answering(string $answer): static
    {
        return $this->state(fn (): array => [
            'answer' => $answer,
            'answer_key' => app(AnswerMatcher::class)->normalize($answer),
        ]);
    }
}
