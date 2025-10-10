<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('aspirations', function (Blueprint $table) {
            // Eliminar campos obsoletos
            $table->dropColumn(['occupation', 'availability', 'hour_range', 'hours_per_week']);
            
            // Agregar nuevos campos
            $table->string('desired_position')->nullable()->comment('Puesto deseado');
            $table->string('sector_of_interest')->nullable()->comment('Sector de interés');
            $table->decimal('expected_salary', 10, 2)->nullable()->comment('Salario esperado en USD');
            $table->json('contract_type_preference')->nullable()->comment('Tipos de contrato preferidos (múltiples)');
            $table->text('short_term_goals')->nullable()->comment('Objetivos a corto plazo (1-2 años)');
            $table->enum('employment_status', ['contratado', 'disponible', 'en_proceso', 'discapacitado', 'fallecido'])->default('disponible')->comment('Estatus laboral');
            $table->enum('work_scope', ['provincial', 'nacional'])->default('provincial')->comment('Alcance laboral');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aspirations', function (Blueprint $table) {
            // Restaurar campos antiguos
            $table->string('occupation')->nullable()->comment('Ocupación');
            $table->string('availability')->nullable()->comment('Disponibilidad');
            $table->string('hour_range')->nullable()->comment('Rango de horas');
            $table->integer('hours_per_week')->nullable()->comment('Horas por semana');
            
            // Eliminar nuevos campos
            $table->dropColumn([
                'desired_position',
                'sector_of_interest',
                'expected_salary',
                'contract_type_preference',
                'short_term_goals',
                'employment_status',
                'work_scope'
            ]);
        });
    }
};
