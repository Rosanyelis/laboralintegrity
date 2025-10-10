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
            // Eliminar el índice único del campo code
            $table->dropUnique(['code']);
            
            // Agregar índice único al campo name
            $table->unique('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reference_codes', function (Blueprint $table) {
            // Restaurar el índice único al campo code
            $table->unique('code');
            
            // Eliminar el índice único del campo name
            $table->dropUnique(['name']);
        });
    }
};
