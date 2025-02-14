<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $duration = fake()->randomElement(['monthly', 'quartely', 'semiannual', 'yearly']);
        $numericDurations = ['monthly' => 1, 'quartely' => 3, 'semiannual' => 6, 'yearly' => 12];
        return [
            'status' => 'active',
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addMonths($numericDurations[$duration])->format('Y-m-d'),
            'duration' => $duration,
            'payment_date' => now(),
            'company_id' => Company::all()->random()->id,
            'plan_id' => Plan::all()->random()->id,
        ];
    }
}
