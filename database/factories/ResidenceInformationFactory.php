<?php

namespace Database\Factories;

use App\Models\ResidenceInformation;
use App\Models\Province;
use App\Models\Municipality;
use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResidenceInformation>
 */
class ResidenceInformationFactory extends Factory
{
    protected $model = ResidenceInformation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $streets = [
            'Calle Principal', 'Av. Independencia', 'Calle Duarte', 'Av. 27 de Febrero',
            'Calle El Conde', 'Av. Winston Churchill', 'Calle Hostos', 'Av. Abraham Lincoln',
            'Calle Sánchez', 'Av. Máximo Gómez', 'Calle Restauración', 'Av. Tiradentes',
            'Calle Las Mercedes', 'Av. Núñez de Cáceres', 'Calle San Martín',
        ];

        $province = Province::inRandomOrder()->first();
        $municipality = Municipality::where('province_id', $province->id)->inRandomOrder()->first();
        $district = District::where('municipality_id', $municipality->id)->inRandomOrder()->first();

        return [
            'street_and_number' => fake()->randomElement($streets) . ' #' . fake()->numberBetween(1, 200),
            'arrival_reference' => fake()->optional(0.7)->passthrough(fake()->randomElement([
                'Frente al parque',
                'Al lado del colmado',
                'Cerca de la escuela',
                'Detrás de la iglesia',
                'Al lado del supermercado',
                'Frente a la farmacia',
                'Cerca del hospital',
            ])),
            'province_id' => $province->id,
            'municipality_id' => $municipality->id,
            'district_id' => $district?->id,
            'sector' => fake()->optional(0.8)->passthrough(fake()->randomElement([
                'Los Jardines', 'Villa Mella', 'Los Mina', 'Cristo Rey', 'Villa Juana',
                'Ensanche La Fe', 'Los Praditos', 'Mata Hambre', 'Pueblo Nuevo',
            ])),
            'neighborhood' => fake()->optional(0.6)->passthrough('Residencial ' . fake()->word()),
            'residential_complex' => fake()->optional(0.3)->passthrough('Residencial ' . fake()->word()),
            'building' => fake()->optional(0.2)->passthrough('Edificio ' . fake()->randomElement(['A', 'B', 'C', 'Torre 1', 'Torre 2'])),
            'apartment' => fake()->optional(0.2)->passthrough(fake()->numberBetween(1, 20) . fake()->randomElement(['A', 'B', 'C', ''])),
            'is_certified' => fake()->boolean(30),
        ];
    }
}
