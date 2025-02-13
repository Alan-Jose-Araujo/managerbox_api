<?php

namespace Database\Seeders;

use App\Models\Metier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class MetierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $getCnaeCodesGenerator = function() {
            $cnaeCodesAsJson = json_decode(Storage::disk('local')->get('cnae_codes.json'), true);
            foreach ($cnaeCodesAsJson as $code => $name) {
                yield $code => $name;
            }
        };
        foreach ($getCnaeCodesGenerator() as $code => $name) {
            Metier::create([
                'name' => $name,
                'cnae_code' => $code,
            ]);
        }
    }
}
