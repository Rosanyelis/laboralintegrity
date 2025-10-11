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
        Schema::table('work_integrities', function (Blueprint $table) {
            $table->text('resultado')->nullable()->after('fecha')->comment('Resultado de la evaluación');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_integrities', function (Blueprint $table) {
            $table->dropColumn(['resultado']);
        });
    }
};
