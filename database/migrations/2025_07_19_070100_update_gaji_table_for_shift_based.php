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
            if (!Schema::hasColumn('gaji', 'jumlah_shift')) {
                $table->integer('jumlah_shift')->default(0)->after('total_jam_kerja');
            }
            if (!Schema::hasColumn('gaji', 'gaji_per_shift')) {
                $table->integer('gaji_per_shift')->default(50000)->after('jumlah_shift');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gaji', function (Blueprint $table) {
            $table->dropColumn(['jumlah_shift', 'gaji_per_shift']);
        });
    }
};
