<?php

namespace Database\Seeders;

use App\Models\Metier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class MetierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Garantir que o Metier Padrão existe antes de inserir outros
        DB::table('metiers')->updateOrInsert(
            ['id' => 1],
            [
                'name' => 'Metier Padrão',
                'cnae_code' => '0000000', // Ajuste conforme necessário
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Gerar os CNAE codes a partir do arquivo JSON
        $getCnaeCodesGenerator = function() {
            $cnaeCodesAsJson = json_decode(Storage::disk('local')->get('cnae_codes.json'), true);
            foreach ($cnaeCodesAsJson as $code => $name) {
                yield $code => $name;
            }
        };

        // Inserir os CNAE codes garantindo que não duplica
        foreach ($getCnaeCodesGenerator() as $code => $name) {
            Metier::updateOrInsert(
                ['cnae_code' => $code],
                ['name' => $name]
            );
        }
    }
}
