<?php

namespace Database\Factories;

use App\Models\Metier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $companyFaker = new \Faker\Provider\pt_BR\Company(fake());
        return [
            'fantasy_name' => fake()->company(),
            'corporate_reason' => fake()->name(),
            'email' => fake()->companyEmail(),
            'email_verified_at' => now(),
            'cnpj' => $companyFaker->cnpj(false),
            'state_registration' => (string) fake()->unique()->randomNumber(9),
            'foundation_date' => fake()->randomElement([null, fake()->date('Y-m-d')]),
            'landline' => (string) fake()->unique()->randomNumber(8),
            'is_active' => fake()->boolean(),
            'timezone' => fake()->timezone('BR'),
            'currency_code' => fake()->currencyCode(),
            'currency_decimal_places' => 2,
            'metier_id' => Metier::all()->random()->id,
        ];
    }
}
