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
        Schema::table('users', function (Blueprint $table) {
            // Agregar el campo person_id como nullable
            $table->foreignId('person_id')->nullable()->after('id')->comment('ID de la persona asociada a este usuario');
            
            // Crear el índice para mejorar el rendimiento
            $table->index('person_id', 'users_person_id_index');
            
            // Crear la foreign key constraint
            $table->foreign('person_id')
                  ->references('id')
                  ->on('people')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Eliminar la foreign key constraint primero
            $table->dropForeign(['person_id']);
            
            // Eliminar el índice
            $table->dropIndex('users_person_id_index');
            
            // Eliminar la columna
            $table->dropColumn('person_id');
        });
    }
};