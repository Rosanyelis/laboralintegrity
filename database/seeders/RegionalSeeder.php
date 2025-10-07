<?php

namespace Database\Seeders;

use App\Models\Regional;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Seeder para las regiones administrativas de República Dominicana
 * 
 * Inserta las 10 regiones oficiales del país con sus respectivos nombres.
 */
class RegionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = [
            ['name' => 'Región Cibao Norte', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Región Cibao Sur', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Región Nordeste o del Cibao Este', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Región Cibao Noroeste', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Región Valdesia', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Región Suroeste o Enriquillo', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Región El Valle', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Región del Yuma', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Región Higuamo', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Región Ozama', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($regions as $region) {
            Regional::create($region);
        }
        $this->command->info('Se han insertado/actualizado ' . count($regions) . ' regiones administrativas.');
    }
}
