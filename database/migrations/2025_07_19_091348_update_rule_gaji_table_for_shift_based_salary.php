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
        Schema::table('rule_gaji', function (Blueprint $table) {
            // Drop the parameter column if it exists
            if (Schema::hasColumn('rule_gaji', 'parameter')) {
                $table->dropColumn('parameter');
            }

            // Add new columns for shift-based salary
            $table->decimal('gaji_per_shift', 10, 2)->default(50000)->after('deskripsi');
            $table->integer('jam_kerja_per_shift')->default(8)->after('gaji_per_shift');
            $table->decimal('rate_lembur_per_jam', 10, 2)->default(6250)->after('jam_kerja_per_shift'); // 50000/8 = 6250
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rule_gaji', function (Blueprint $table) {
            $table->dropColumn(['gaji_per_shift', 'jam_kerja_per_shift', 'rate_lembur_per_jam']);
            $table->json('parameter')->nullable();
        });
    }
};
