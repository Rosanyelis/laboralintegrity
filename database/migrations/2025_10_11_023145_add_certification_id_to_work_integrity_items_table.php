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
        Schema::table('work_integrity_items', function (Blueprint $table) {
            $table->foreignId('certification_id')->nullable()->after('work_integrity_id')->constrained('certifications')->onDelete('set null')->comment('Tipo de depuración');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_integrity_items', function (Blueprint $table) {
            $table->dropForeign(['certification_id']);
            $table->dropColumn('certification_id');
        });
    }
};
