<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'street' => fake()->streetName(),
            'building_number' => fake()->buildingNumber(),
            'complement' => fake()->text(),
            'neighborhood' => fake()->sentence(),
            'city' => fake()->city(),
            'state' => fake()->randomElement(['PE', 'PB', 'BA', 'SP', 'MG', 'RS']),
            'zipcode' => (string) fake()->randomNumber(8),
            'country' => 'BR',
            'addressable_type' => fake()->randomElement([Company::class, User::class]),
            'addressable_id' => fake()->randomNumber([Company::factory(), User::factory()]),
        ];
    }
}
