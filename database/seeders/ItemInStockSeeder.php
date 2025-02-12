<?php

namespace Database\Seeders;

use App\Models\ItemInStock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemInStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ItemInStock::factory(200)->create();
    }
}
