<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Vaciar las tablas primero
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('work_integrity_items')->truncate();
        DB::table('work_integrities')->truncate();
        DB::table('reference_codes')->truncate();
        DB::table('certifications')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Eliminar campos de certification en work_integrity_items
        Schema::table('work_integrity_items', function (Blueprint $table) {
            // Eliminar foreign key constraint
            $table->dropForeign(['certification_id']);
            
            // Eliminar índice
            $table->dropIndex(['certification_id']);
            
            // Eliminar los campos
            $table->dropColumn(['certification_id', 'certification_name']);
        });

        // Eliminar campos en reference_codes
        Schema::table('reference_codes', function (Blueprint $table) {
            // Eliminar la foreign key constraint primero
            $table->dropForeign(['certification_id']);
            
            // Eliminar el índice único de name si existe
            $table->dropUnique(['name']);
            
            // Eliminar los campos
            $table->dropColumn(['certification_id', 'name', 'is_active']);
            
            // Hacer code único nuevamente
            $table->unique('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restaurar campos en reference_codes
        Schema::table('reference_codes', function (Blueprint $table) {
            // Eliminar unique de code
            $table->dropUnique(['code']);
            
            // Restaurar los campos
            $table->foreignId('certification_id')->after('id')->constrained('certifications')->onDelete('cascade')->comment('Tipo de depuración');
            $table->string('name')->after('code')->comment('Nombre del código de referencia');
            $table->boolean('is_active')->default(true)->after('description')->comment('Estado activo/inactivo');
            
            // Añadir unique a name
            $table->unique('name');
        });

        // Restaurar campos en work_integrity_items
        Schema::table('work_integrity_items', function (Blueprint $table) {
            // Restaurar los campos
            $table->foreignId('certification_id')->after('work_integrity_id')->constrained('certifications')->onDelete('cascade');
            $table->string('certification_name')->after('certification_id')->comment('Nombre del tipo de certificación');
            
            // Restaurar índice
            $table->index('certification_id');
        });
    }
};
