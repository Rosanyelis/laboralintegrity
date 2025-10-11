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
        Schema::table('reference_codes', function (Blueprint $table) {
            // Eliminar el campo description
            $table->dropColumn('description');
            
            // Agregar el campo actual_result
            $table->string('actual_result')->after('result')->nullable()->comment('Resultado real');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reference_codes', function (Blueprint $table) {
            // Restaurar el campo description
            $table->text('description')->after('result')->nullable()->comment('Descripción adicional');
            
            // Eliminar el campo actual_result
            $table->dropColumn('actual_result');
        });
    }
};
