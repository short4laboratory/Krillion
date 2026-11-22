<?php

namespace Database\Factories;

use App\Models\Dive;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Dive>
 */
class DiveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'player_name' => fake()->firstName(),
            'question_ids' => [],
            'total_score' => 0,
            'completed_at' => null,
        ];
    }

    /**
     * A dive that has reached the bottom with the given score.
     */
    public function completed(int $totalScore = 350): static
    {
        return $this->state(fn (): array => [
            'total_score' => $totalScore,
            'completed_at' => now(),
        ]);
    }
}
