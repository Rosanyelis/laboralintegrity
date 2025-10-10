<?php

namespace Database\Factories;

use App\Models\WorkExperience;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkExperience>
 */
class WorkExperienceFactory extends Factory
{
    protected $model = WorkExperience::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $companies = [
            'Banco Popular', 'Banco BHD León', 'Banco Reservas', 'Claro Dominicana', 'Altice',
            'Grupo Ramos', 'Grupo Rica', 'Cervecería Nacional Dominicana', 'Induveca', 'Quirch',
            'CCN', 'Supercentro Nacional', 'La Sirena', 'Jumbo', 'PriceSmart', 'Almacenes Unidos',
            'Farmacia Carol', 'Farmacias El Amal', 'Distribuidora Corripio', 'Editora Listin Diario',
            'Constructora Estrella', 'Supermercados Nacional', 'Plaza Lama', 'Ferretería Americana',
        ];

        $positions = [
            'Asistente Administrativo', 'Contador', 'Vendedor', 'Supervisor de Ventas', 'Gerente de Tienda',
            'Recepcionista', 'Técnico de Soporte', 'Analista de Sistemas', 'Coordinador de Logística',
            'Ejecutivo de Ventas', 'Auxiliar Contable', 'Desarrollador Web', 'Diseñador Gráfico',
            'Asistente de Recursos Humanos', 'Operador de Máquinas', 'Almacenista', 'Chofer',
            'Mensajero', 'Secretaria Ejecutiva', 'Auxiliar de Almacén', 'Cajero', 'Encargado de Compras',
        ];

        $achievements = [
            'Incrementé las ventas en un 25% durante mi gestión',
            'Implementé un nuevo sistema de inventario que redujo pérdidas',
            'Capacité a 15 empleados nuevos',
            'Mejoré los procesos de atención al cliente',
            'Reduje los tiempos de entrega en un 30%',
            'Mantuve un record de cero quejas de clientes',
            'Logré las metas de ventas durante 12 meses consecutivos',
            'Desarrollé procedimientos que aumentaron la eficiencia',
        ];

        $startYear = fake()->numberBetween(2010, 2022);
        $endYear = fake()->numberBetween($startYear + 1, 2024);

        return [
            'company_name' => fake()->randomElement($companies),
            'position' => fake()->randomElement($positions),
            'year_range' => $startYear . '-' . $endYear,
            'achievements' => fake()->optional(0.8)->passthrough(fake()->randomElement($achievements)),
        ];
    }
}
