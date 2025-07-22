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
        Schema::table('rule_shift', function (Blueprint $table) {
            $table->renameColumn('max_shift_per_bulan', 'max_shift_per_minggu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rule_shift', function (Blueprint $table) {
            $table->renameColumn('max_shift_per_minggu', 'max_shift_per_bulan');
        });
    }
};
