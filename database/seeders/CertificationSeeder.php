<?php

namespace Database\Seeders;

use App\Models\Certification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CertificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $certifications = [
            ['name' => 'Procuraduría'],
            ['name' => 'Policía Nacional'],
            ['name' => 'Otras Actividades personales'],
            ['name' => 'Actividades no procesadas'],
            ['name' => 'Prueba Poligráfica'],
            ['name' => 'Prueba Psicométrica'],
            ['name' => 'Prueba de Contagio'],
            ['name' => 'Sustancia Prohibida'],
            ['name' => 'No Abusa Alcohol'],
            ['name' => 'Investigación de entorno'],
            ['name' => 'Integridad Familiar'],
            ['name' => 'Levantamiento Dactilares'],
            ['name' => 'Características Fotográfica'],
        ];

        foreach ($certifications as $certification) {
            Certification::firstOrCreate(
                ['name' => $certification['name']],
                $certification
            );
        }
    }
}
