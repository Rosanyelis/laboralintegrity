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
            ['name' => 'Procuraduria'],
            ['name' => 'Investigaciones (Hoja de vida)'],
            ['name' => 'Analiticas y Psicometría'],
            ['name' => 'Visita Domiciliaria'],
            ['name' => 'Levantamiento de Caracteristicas'],
        ];

        foreach ($certifications as $certification) {
            Certification::create($certification);
        }
    }
}
