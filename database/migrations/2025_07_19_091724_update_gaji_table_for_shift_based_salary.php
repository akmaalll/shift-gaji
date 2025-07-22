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
        Schema::table('gaji', function (Blueprint $table) {
            // Drop the old total_jam_kerja column
            $table->dropColumn('total_jam_kerja');

            // Add new columns for shift-based salary
            $table->integer('total_shift')->default(0)->after('bulan');
            $table->integer('total_jam_lembur')->default(0)->after('total_shift');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gaji', function (Blueprint $table) {
            $table->dropColumn(['total_shift', 'total_jam_lembur']);
            $table->integer('total_jam_kerja')->after('bulan');
        });
    }
};
