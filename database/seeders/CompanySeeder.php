<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creando 30 empresas con datos de ejemplo...');

        // Crear 25 empresas regulares
        Company::factory()->count(25)->create();

        // Crear 5 empresas con sucursal
        Company::factory()
            ->count(5)
            ->withBranch()
            ->withExtension()
            ->create();

        $this->command->info('✓ Se crearon 30 empresas (25 regulares + 5 con sucursal).');
    }
}
