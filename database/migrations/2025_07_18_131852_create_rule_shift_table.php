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
        Schema::create('rule_shift', function (Blueprint $table) {
            $table->id();
            $table->string('nama_rule');
            $table->text('deskripsi')->nullable();
            $table->integer('max_shift_per_bulan')->nullable();
            $table->integer('min_jeda_hari')->nullable();
            $table->integer('min_karyawan_per_shift')->default(2);
            $table->boolean('rotasi_mingguan')->default(true);
            $table->boolean('fairness')->default(true);
            $table->boolean('prioritas_shift_malam')->default(true);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rule_shift');
    }
};
