<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PlanLimit>
 */
class PlanLimitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'feature' => fake()->unique()->word(),
            'limit' => fake()->randomFloat(2, 0, 1000),
            'plan_id' => Plan::factory()
        ];
    }
}
