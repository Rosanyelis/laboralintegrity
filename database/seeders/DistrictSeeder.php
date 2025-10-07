<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Seeder para los distritos municipales de República Dominicana
 * 
 * Inserta los distritos municipales basados en los datos de la tabla sectors.
 * Nota: Este seeder asume que los municipios ya han sido creados.
 */
class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            // Distritos del Distrito Nacional y otras provincias principales
            ['municipality_id' => 1, 'name' => 'Distrito Nacional', 'created_at' => now(), 'updated_at' => now()],
            
            // Algunos distritos representativos de diferentes municipios
            ['municipality_id' => 2, 'name' => 'Barreras', 'created_at' => now(), 'updated_at' => now()],
            ['municipality_id' => 2, 'name' => 'Barro Arriba', 'created_at' => now(), 'updated_at' => now()],
            ['municipality_id' => 2, 'name' => 'Clavellina', 'created_at' => now(), 'updated_at' => now()],
            ['municipality_id' => 2, 'name' => 'Emma Balaguer Viuda Vallejo', 'created_at' => now(), 'updated_at' => now()],
            ['municipality_id' => 2, 'name' => 'Las Barías-La Estancia', 'created_at' => now(), 'updated_at' => now()],
            ['municipality_id' => 2, 'name' => 'Las Lomas', 'created_at' => now(), 'updated_at' => now()],
            ['municipality_id' => 2, 'name' => 'Los Jovillos', 'created_at' => now(), 'updated_at' => now()],
            ['municipality_id' => 2, 'name' => 'Puerto Viejo', 'created_at' => now(), 'updated_at' => now()],
            
            ['municipality_id' => 5, 'name' => 'Hatillo', 'created_at' => now(), 'updated_at' => now()],
            ['municipality_id' => 5, 'name' => 'Palmar de Ocoa', 'created_at' => now(), 'updated_at' => now()],
            
            ['municipality_id' => 6, 'name' => 'Villarpando', 'created_at' => now(), 'updated_at' => now()],
            ['municipality_id' => 6, 'name' => 'Hato Nuevo-Cortés', 'created_at' => now(), 'updated_at' => now()],
            
            ['municipality_id' => 7, 'name' => 'La Siembra', 'created_at' => now(), 'updated_at' => now()],
            ['municipality_id' => 7, 'name' => 'Las Lagunas', 'created_at' => now(), 'updated_at' => now()],
            ['municipality_id' => 7, 'name' => 'Los Fríos', 'created_at' => now(), 'updated_at' => now()],
            
            ['municipality_id' => 9, 'name' => 'El Rosario', 'created_at' => now(), 'updated_at' => now()],
            
            ['municipality_id' => 10, 'name' => 'Proyecto 4', 'created_at' => now(), 'updated_at' => now()],
            ['municipality_id' => 10, 'name' => 'Ganadero', 'created_at' => now(), 'updated_at' => now()],
            ['municipality_id' => 10, 'name' => 'Proyecto 2-C', 'created_at' => now(), 'updated_at' => now()],
            
            ['municipality_id' => 11, 'name' => 'Amiama Gómez', 'created_at' => now(), 'updated_at' => now()],
            ['municipality_id' => 11, 'name' => 'Los Toros', 'created_at' => now(), 'updated_at' => now()],
            ['municipality_id' => 11, 'name' => 'Tábaro Abajo', 'created_at' => now(), 'updated_at' => now()],
            
            ['municipality_id' => 12, 'name' => 'El Palmar', 'created_at' => now(), 'updated_at' => now()],
            
            ['municipality_id' => 13, 'name' => 'El Salado', 'created_at' => now(), 'updated_at' => now()],
            
            ['municipality_id' => 14, 'name' => 'Las Clavellinas', 'created_at' => now(), 'updated_at' => now()],
            
            ['municipality_id' => 15, 'name' => 'Cabeza de Toro', 'created_at' => now(), 'updated_at' => now()],
            ['municipality_id' => 15, 'name' => 'Mena', 'created_at' => now(), 'updated_at' => now()],
            ['municipality_id' => 15, 'name' => 'Monserrat', 'created_at' => now(), 'updated_at' => now()],
            ['municipality_id' => 15, 'name' => 'Santa Bárbara-El 6', 'created_at' => now(), 'updated_at' => now()],
            ['municipality_id' => 15, 'name' => 'Santana', 'created_at' => now(), 'updated_at' => now()],
            ['municipality_id' => 15, 'name' => 'Uvilla', 'created_at' => now(), 'updated_at' => now()],
            
            ['municipality_id' => 17, 'name' => 'El Cachón', 'created_at' => now(), 'updated_at' => now()],
            ['municipality_id' => 17, 'name' => 'La Guázara', 'created_at' => now(), 'updated_at' => now()],
            ['municipality_id' => 17, 'name' => 'Villa Central', 'created_at' => now(), 'updated_at' => now()],
            
            ['municipality_id' => 20, 'name' => 'Arroyo Dulce', 'created_at' => now(), 'updated_at' => now()],
            
            ['municipality_id' => 21, 'name' => 'Pescadería', 'created_at' => now(), 'updated_at' => now()],
            
            ['municipality_id' => 22, 'name' => 'Palo Alto', 'created_at' => now(), 'updated_at' => now()],
            
            ['municipality_id' => 23, 'name' => 'Bahoruco', 'created_at' => now(), 'updated_at' => now()],
            
            ['municipality_id' => 25, 'name' => 'Los Patos', 'created_at' => now(), 'updated_at' => now()],
            
            ['municipality_id' => 27, 'name' => 'Canoa', 'created_at' => now(), 'updated_at' => now()],
            ['municipality_id' => 27, 'name' => 'Fondo Negro', 'created_at' => now(), 'updated_at' => now()],
            ['municipality_id' => 27, 'name' => 'Quita Coraza', 'created_at' => now(), 'updated_at' => now()],
            
            ['municipality_id' => 28, 'name' => 'Cañongo', 'created_at' => now(), 'updated_at' => now()],
            
            ['municipality_id' => 29, 'name' => 'Manuel Bueno', 'created_at' => now(), 'updated_at' => now()],
            
            ['municipality_id' => 30, 'name' => 'Capotillo', 'created_at' => now(), 'updated_at' => now()],
            ['municipality_id' => 30, 'name' => 'Santiago de la Cruz', 'created_at' => now(), 'updated_at' => now()],
            
            // Agregar más distritos según sea necesario
            // Nota: Este es un subconjunto de los 226 distritos disponibles
            // Se pueden agregar más distritos expandiendo este array
        ];

        foreach ($districts as $district) {
            District::create($district);
        }

        $this->command->info('Se han insertado ' . count($districts) . ' distritos municipales.');
        $this->command->info('Nota: Este es un subconjunto de los distritos disponibles. Se pueden agregar más según sea necesario.');
    }
}
