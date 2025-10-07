<?php

namespace Database\Seeders;

use App\Models\Municipality;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Seeder para los municipios de República Dominicana
 * 
 * Inserta los 155 municipios oficiales del país con sus respectivas provincias.
 * Nota: Este seeder asume que las provincias ya han sido creadas.
 */
class MunicipalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $municipalities = [
            // Distrito Nacional (Provincia 1)
            ['province_id' => 1, 'name' => 'Distrito Nacional', 'created_at' => now(), 'updated_at' => now()],
            
            // Azua (Provincia 2)
            ['province_id' => 2, 'name' => 'Azua de Compostela', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 2, 'name' => 'Estebanía', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 2, 'name' => 'Guayabal', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 2, 'name' => 'Las Charcas', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 2, 'name' => 'Las Yayas de Viajama', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 2, 'name' => 'Padre Las Casas', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 2, 'name' => 'Peralta', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 2, 'name' => 'Pueblo Viejo', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 2, 'name' => 'Sabana Yegua', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 2, 'name' => 'Tábara Arriba', 'created_at' => now(), 'updated_at' => now()],
            
            // Baoruco (Provincia 3)
            ['province_id' => 3, 'name' => 'Neiba', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 3, 'name' => 'Galván', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 3, 'name' => 'Los Ríos', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 3, 'name' => 'Tamayo', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 3, 'name' => 'Villa Jaragua', 'created_at' => now(), 'updated_at' => now()],
            
            // Barahona (Provincia 4)
            ['province_id' => 4, 'name' => 'Barahona', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 4, 'name' => 'Cabral', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 4, 'name' => 'El Peñón', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 4, 'name' => 'Enriquillo', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 4, 'name' => 'Fundación', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 4, 'name' => 'Jaquimeyes', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 4, 'name' => 'La Ciénaga', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 4, 'name' => 'Las Salinas', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 4, 'name' => 'Paraíso', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 4, 'name' => 'Polo', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 4, 'name' => 'Vicente Noble', 'created_at' => now(), 'updated_at' => now()],
            
            // Dajabón (Provincia 5)
            ['province_id' => 5, 'name' => 'Dajabón', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 5, 'name' => 'El Pino', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 5, 'name' => 'Loma de Cabrera', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 5, 'name' => 'Partido', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 5, 'name' => 'Restauración', 'created_at' => now(), 'updated_at' => now()],
            
            // Duarte (Provincia 6)
            ['province_id' => 6, 'name' => 'San Francisco de Macorís', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 6, 'name' => 'Arenoso', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 6, 'name' => 'Castillo', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 6, 'name' => 'Eugenio María de Hostos', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 6, 'name' => 'Las Guáranas', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 6, 'name' => 'Pimentel', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 6, 'name' => 'Villa Riva', 'created_at' => now(), 'updated_at' => now()],
            
            // El Seibo (Provincia 7)
            ['province_id' => 7, 'name' => 'El Seibo', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 7, 'name' => 'Miches', 'created_at' => now(), 'updated_at' => now()],
            
            // Elías Piña (Provincia 8)
            ['province_id' => 8, 'name' => 'Comendador', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 8, 'name' => 'Bánica', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 8, 'name' => 'El Llano', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 8, 'name' => 'Hondo Valle', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 8, 'name' => 'Juan Santiago', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 8, 'name' => 'Pedro Santana', 'created_at' => now(), 'updated_at' => now()],
            
            // Espaillat (Provincia 9)
            ['province_id' => 9, 'name' => 'Moca', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 9, 'name' => 'Cayetano Germosén', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 9, 'name' => 'Gaspar Hernández', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 9, 'name' => 'Jamao al Norte', 'created_at' => now(), 'updated_at' => now()],
            
            // Hato Mayor (Provincia 10)
            ['province_id' => 10, 'name' => 'Hato Mayor del Rey', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 10, 'name' => 'El Valle', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 10, 'name' => 'Sabana de la Mar', 'created_at' => now(), 'updated_at' => now()],
            
            // Hermanas Mirabal (Provincia 11)
            ['province_id' => 11, 'name' => 'Salcedo', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 11, 'name' => 'Tenares', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 11, 'name' => 'Villa Tapia', 'created_at' => now(), 'updated_at' => now()],
            
            // Independencia (Provincia 12)
            ['province_id' => 12, 'name' => 'Jimaní', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 12, 'name' => 'Cristóbal', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 12, 'name' => 'Duvergé', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 12, 'name' => 'La Descubierta', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 12, 'name' => 'Mella', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 12, 'name' => 'Postrer Río', 'created_at' => now(), 'updated_at' => now()],
            
            // La Altagracia (Provincia 13)
            ['province_id' => 13, 'name' => 'Higüey', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 13, 'name' => 'San Rafael del Yuma', 'created_at' => now(), 'updated_at' => now()],
            
            // La Romana (Provincia 14)
            ['province_id' => 14, 'name' => 'La Romana', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 14, 'name' => 'Guaymate', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 14, 'name' => 'Villa Hermosa', 'created_at' => now(), 'updated_at' => now()],
            
            // La Vega (Provincia 15)
            ['province_id' => 15, 'name' => 'La Concepción de La Vega', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 15, 'name' => 'Constanza', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 15, 'name' => 'Jarabacoa', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 15, 'name' => 'Jima Abajo', 'created_at' => now(), 'updated_at' => now()],
            
            // María Trinidad Sánchez (Provincia 16)
            ['province_id' => 16, 'name' => 'Nagua', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 16, 'name' => 'Cabrera', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 16, 'name' => 'El Factor', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 16, 'name' => 'Río San Juan', 'created_at' => now(), 'updated_at' => now()],
            
            // Monseñor Nouel (Provincia 17)
            ['province_id' => 17, 'name' => 'Bonao', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 17, 'name' => 'Maimón', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 17, 'name' => 'Piedra Blanca', 'created_at' => now(), 'updated_at' => now()],
            
            // Montecristi (Provincia 18)
            ['province_id' => 18, 'name' => 'Montecristi', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 18, 'name' => 'Castañuela', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 18, 'name' => 'Guayubín', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 18, 'name' => 'Las Matas de Santa Cruz', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 18, 'name' => 'Pepillo Salcedo', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 18, 'name' => 'Villa Vásquez', 'created_at' => now(), 'updated_at' => now()],
            
            // Monte Plata (Provincia 19)
            ['province_id' => 19, 'name' => 'Monte Plata', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 19, 'name' => 'Bayaguana', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 19, 'name' => 'Peralvillo', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 19, 'name' => 'Sabana Grande de Boyá', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 19, 'name' => 'Yamasá', 'created_at' => now(), 'updated_at' => now()],
            
            // Pedernales (Provincia 20)
            ['province_id' => 20, 'name' => 'Pedernales', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 20, 'name' => 'Oviedo', 'created_at' => now(), 'updated_at' => now()],
            
            // Peravia (Provincia 21)
            ['province_id' => 21, 'name' => 'Baní', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 21, 'name' => 'Nizao', 'created_at' => now(), 'updated_at' => now()],
            
            // Puerto Plata (Provincia 22)
            ['province_id' => 22, 'name' => 'Puerto Plata', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 22, 'name' => 'Altamira', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 22, 'name' => 'Guananico', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 22, 'name' => 'Imbert', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 22, 'name' => 'Los Hidalgos', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 22, 'name' => 'Luperón', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 22, 'name' => 'Sosúa', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 22, 'name' => 'Villa Isabela', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 22, 'name' => 'Villa Montellano', 'created_at' => now(), 'updated_at' => now()],
            
            // Samaná (Provincia 23)
            ['province_id' => 23, 'name' => 'Samaná', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 23, 'name' => 'Las Terrenas', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 23, 'name' => 'Sánchez', 'created_at' => now(), 'updated_at' => now()],
            
            // San Cristóbal (Provincia 24)
            ['province_id' => 24, 'name' => 'San Cristóbal', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 24, 'name' => 'Bajos de Haina', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 24, 'name' => 'Cambita Garabito', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 24, 'name' => 'Los Cacaos', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 24, 'name' => 'Sabana Grande de Palenque', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 24, 'name' => 'San Gregorio de Nigua', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 24, 'name' => 'Villa Altagracia', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 24, 'name' => 'Yaguate', 'created_at' => now(), 'updated_at' => now()],
            
            // San José de Ocoa (Provincia 25)
            ['province_id' => 25, 'name' => 'San José de Ocoa', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 25, 'name' => 'Rancho Arriba', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 25, 'name' => 'Sabana Larga', 'created_at' => now(), 'updated_at' => now()],
            
            // San Juan (Provincia 26)
            ['province_id' => 26, 'name' => 'San Juan de la Maguana', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 26, 'name' => 'Bohechío', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 26, 'name' => 'El Cercado', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 26, 'name' => 'Juan de Herrera', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 26, 'name' => 'Las Matas de Farfán', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 26, 'name' => 'Vallejuelo', 'created_at' => now(), 'updated_at' => now()],
            
            // San Pedro de Macorís (Provincia 27)
            ['province_id' => 27, 'name' => 'San Pedro de Macorís', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 27, 'name' => 'Consuelo', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 27, 'name' => 'Guayacanes', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 27, 'name' => 'Quisqueya', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 27, 'name' => 'Ramón Santana', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 27, 'name' => 'San José de Los Llanos', 'created_at' => now(), 'updated_at' => now()],
            
            // Sánchez Ramírez (Provincia 28)
            ['province_id' => 28, 'name' => 'Cotuí', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 28, 'name' => 'Cevicos', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 28, 'name' => 'Fantino', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 28, 'name' => 'La Mata', 'created_at' => now(), 'updated_at' => now()],
            
            // Santiago (Provincia 29)
            ['province_id' => 29, 'name' => 'Santiago', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 29, 'name' => 'Bisonó', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 29, 'name' => 'Jánico', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 29, 'name' => 'Licey al Medio', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 29, 'name' => 'Puñal', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 29, 'name' => 'Sabana Iglesia', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 29, 'name' => 'Tamboril', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 29, 'name' => 'San José de las Matas', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 29, 'name' => 'Villa González', 'created_at' => now(), 'updated_at' => now()],
            
            // Santiago Rodríguez (Provincia 30)
            ['province_id' => 30, 'name' => 'San Ignacio de Sabaneta', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 30, 'name' => 'Los Almácigos', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 30, 'name' => 'Monción', 'created_at' => now(), 'updated_at' => now()],
            
            // Santo Domingo (Provincia 31)
            ['province_id' => 31, 'name' => 'Santo Domingo Este', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 31, 'name' => 'Boca Chica', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 31, 'name' => 'Los Alcarrizos', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 31, 'name' => 'Pedro Brand', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 31, 'name' => 'San Antonio de Guerra', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 31, 'name' => 'Santo Domingo Norte', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 31, 'name' => 'Santo Domingo Oeste', 'created_at' => now(), 'updated_at' => now()],
            
            // Valverde (Provincia 32)
            ['province_id' => 32, 'name' => 'Mao', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 32, 'name' => 'Esperanza', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 32, 'name' => 'Laguna Salada', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($municipalities as $municipality) {
            Municipality::create($municipality);
        }

        $this->command->info('Se han insertado ' . count($municipalities) . ' municipios.');
    }
}
