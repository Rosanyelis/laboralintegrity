<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Person;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder principal de la base de datos
 * 
 * Ejecuta todos los seeders en orden y crea un usuario administrador por defecto.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Iniciando proceso de seeding...');

        // Ejecutar seeders geográficos en orden
        $this->call([
            RegionalSeeder::class,
            ProvinceSeeder::class,
            MunicipalitySeeder::class,
            DistrictSeeder::class,
        ]);

        $this->command->info('Datos geográficos insertados exitosamente.');

        // Ejecutar seeder de certificaciones
        $this->call([
            CertificationSeeder::class,
        ]);

        // Ejecutar seeder de códigos de referencia
        $this->call([
            ReferenceCodeSeeder::class,
        ]);

        // Ejecutar seeder de permisos y roles
        $this->call([
            PermissionSeeder::class,
        ]);

        // Crear usuario administrador por defecto
        $adminUser = User::create([
            'name' => 'Administrador del Sistema',
            'email' => 'admin@sistema.com',
            'password' => Hash::make('password'),
        ]);

        // Asignar rol de Super Administrador
        $adminUser->assignRole('Super Administrador');

        $this->command->info('Usuario administrador creado:');
        $this->command->info('Email: admin@sistema.com');
        $this->command->info('Password: password');
        $this->command->info('Rol: Super Administrador');

        // Ejecutar seeders de datos de ejemplo (opcional)
        if ($this->command->confirm('¿Desea generar datos de ejemplo? (30 personas y 30 empresas)', true)) {
            $this->call([
                PersonSeeder::class,
                CompanySeeder::class,
            ]);
            
            $this->command->info('Datos de ejemplo generados exitosamente.');
        }

        $this->command->info('Seeding completado exitosamente.');
    }
}
