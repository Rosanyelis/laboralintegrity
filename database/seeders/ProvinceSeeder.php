<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Seeder para las provincias de República Dominicana
 * 
 * Inserta las 32 provincias oficiales del país con sus respectivas regiones.
 * Cada provincia está asociada a su región administrativa correspondiente.
 * Nota: Este seeder asume que las regiones ya han sido creadas.
 */
class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinces = [
            ['regional_id' => 10, 'name' => 'Distrito Nacional', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 5, 'name' => 'Azua', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 6, 'name' => 'Baoruco', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 6, 'name' => 'Barahona', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 4, 'name' => 'Dajabón', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 3, 'name' => 'Duarte', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 8, 'name' => 'El Seibo', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 6, 'name' => 'Elías Piña', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 1, 'name' => 'Espaillat', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 9, 'name' => 'Hato Mayor', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 3, 'name' => 'Hermanas Mirabal', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 6, 'name' => 'Independencia', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 8, 'name' => 'La Altagracia', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 8, 'name' => 'La Romana', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 2, 'name' => 'La Vega', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 3, 'name' => 'María Trinidad Sánchez', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 2, 'name' => 'Monseñor Nouel', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 4, 'name' => 'Montecristi', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 9, 'name' => 'Monte Plata', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 6, 'name' => 'Pedernales', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 5, 'name' => 'Peravia', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 1, 'name' => 'Puerto Plata', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 3, 'name' => 'Samaná', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 5, 'name' => 'San Cristóbal', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 5, 'name' => 'San José de Ocoa', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 6, 'name' => 'San Juan', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 9, 'name' => 'San Pedro de Macorís', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 2, 'name' => 'Sánchez Ramírez', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 1, 'name' => 'Santiago', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 4, 'name' => 'Santiago Rodríguez', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 10, 'name' => 'Santo Domingo', 'created_at' => now(), 'updated_at' => now()],
            ['regional_id' => 4, 'name' => 'Valverde', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($provinces as $province) {
            Province::create($province);
        }

        $this->command->info('Se han insertado ' . count($provinces) . ' provincias.');
    }
}
