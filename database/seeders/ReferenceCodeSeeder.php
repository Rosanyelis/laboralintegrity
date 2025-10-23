<?php

namespace Database\Seeders;

use App\Models\ReferenceCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReferenceCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $referenceCodes = [
            [
                'code' => '1001',
                'result' => 'Excelente',
                'actual_result' => 'Actividad Delictiva',
            ],
            [
                'code' => '1002',
                'result' => 'Excelente',
                'actual_result' => 'Falta de Probidad',
            ],
            [
                'code' => '1003',
                'result' => 'Excelente',
                'actual_result' => 'Falta Grave',
            ],
            [
                'code' => '1004',
                'result' => 'Excelente',
                'actual_result' => 'Fortalecer',
            ],
            [
                'code' => '1005',
                'result' => 'Pendiente',
                'actual_result' => 'Pendiente',
            ],
            [
                'code' => '1006',
                'result' => 'Sin novedad',
                'actual_result' => 'Sin novedad',
            ],
        ];

        foreach ($referenceCodes as $referenceCode) {
            ReferenceCode::firstOrCreate(
                ['code' => $referenceCode['code']],
                $referenceCode
            );
        }
    }
}
