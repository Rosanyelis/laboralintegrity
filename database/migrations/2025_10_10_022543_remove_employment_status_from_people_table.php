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
        Schema::table('people', function (Blueprint $table) {
            $table->dropColumn('employment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->enum('employment_status', ['pendiente', 'disponible', 'en_proceso', 'contratado', 'part_time', 'despido', 'desaucio', 'renuncia', 'aplica', 'no_aplica'])->default('pendiente')->comment('Estado de empleo');
        });
    }
};
