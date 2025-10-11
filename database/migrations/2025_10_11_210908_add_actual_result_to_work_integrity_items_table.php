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
            $table->text('actual_result')->nullable()->after('reference_name')->comment('Resultado real');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_integrity_items', function (Blueprint $table) {
            $table->dropColumn('actual_result');
        });
    }
};
