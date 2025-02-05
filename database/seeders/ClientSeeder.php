<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::factory(20)->create()
        ->each(function ($company) {

            Address::factory()->create([
                'addressable_type' => Company::class,
                'addressable_id' => $company->id,
            ]);

            User::factory()->create([
                'company_id' => $company->id,
            ])->each(function ($user) {
                Address::factory()->create([
                    'addressable_type' => User::class,
                    'addressable_id' => $user->id,
                ]);
            });

            User::factory(10)->create([
                'company_id' => $company->id,
            ])->each(function ($user) {
                Address::factory()->create([
                    'addressable_type' => User::class,
                    'addressable_id' => $user->id,
                ]);
            });

        });
    }
}
