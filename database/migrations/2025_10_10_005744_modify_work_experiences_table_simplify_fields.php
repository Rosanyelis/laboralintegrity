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
        Schema::table('work_experiences', function (Blueprint $table) {
            // Eliminar campos que no se van a usar
            $table->dropColumn(['from_date', 'to_date', 'responsibilities', 'skills']);
            
            // Agregar nuevo campo para el rango de años
            $table->string('year_range')->nullable()->after('position')->comment('Rango de años (Ej: 2020-2023)');
            
            // Modificar el campo achievements para hacerlo más largo
            $table->text('achievements')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_experiences', function (Blueprint $table) {
            // Restaurar campos eliminados
            $table->date('from_date')->nullable()->after('position')->comment('Fecha de inicio');
            $table->date('to_date')->nullable()->after('from_date')->comment('Fecha de fin');
            $table->text('responsibilities')->nullable()->after('achievements')->comment('Responsabilidades');
            $table->text('skills')->nullable()->after('responsibilities')->comment('Habilidades');
            
            // Eliminar el campo year_range
            $table->dropColumn('year_range');
        });
    }
};
