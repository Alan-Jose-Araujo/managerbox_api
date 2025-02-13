<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\PlanLimit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::factory(5)->create()->each(function (Plan $plan) {
            PlanLimit::factory(5)->create([
                'plan_id' => $plan->id,
            ]);
        });
    }
}
