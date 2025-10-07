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

        // Crear usuario administrador por defecto
        $adminUser = User::create([
            'name' => 'Administrador',
            'email' => 'admin@sistema.com',
            'password' => Hash::make('password'),
        ]);

        $this->command->info('Usuario administrador creado:');
        $this->command->info('Email: admin@sistema.com');
        $this->command->info('Password: password');

        // Crear una persona de ejemplo asociada al administrador
        $adminPerson = Person::create([
            'user_id' => $adminUser->id,
            'name' => 'Administrador',
            'last_name' => 'del Sistema',
            'dni' => '00000000000',
            'country' => 'República Dominicana',
            'birth_place' => 'Santo Domingo',
            'birth_date' => '1990-01-01',
            'verification_status' => 'certificado',
            'employment_status' => 'contratado',
        ]);

        // Actualizar el usuario con la referencia a la persona
        $adminUser->update(['person_id' => $adminPerson->id]);

        $this->command->info('Persona de administrador creada exitosamente.');
        $this->command->info('Seeding completado exitosamente.');
    }
}
