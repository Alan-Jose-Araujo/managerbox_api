<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ItemInStock>
 */
class ItemInStockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sku_code' => \Illuminate\Support\Str::random(20),
            'barcode' => \Illuminate\Support\Str::random(50),
            'name' => fake()->word(),
            'description' => fake()->text(),
            'unity_type' => 'unity',
            'current_quantity' => fake()->random_int(0, 100),
            'maximum_quantity' => fake()->randomFloat(2, 0, 100),
            'cost_price' => fake()->randomFloat(2, 0, 1000),
            'sell_price' => fake()->randomFloat(2, 0, 1000),
            'picture' => fake()->filePath(),
            'location' => fake()->text(),
            'is_active' => fake()->boolean(),
            'company_id' => Company::factory(),
        ];
    }
}
