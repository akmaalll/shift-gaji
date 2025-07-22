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
        Schema::create('cuti_rules', function (Blueprint $table) {
            $table->id();
            $table->string('nama_rule');
            $table->integer('max_cuti_per_minggu')->default(1);
            $table->integer('max_cuti_per_bulan')->default(3);
            $table->integer('jatah_libur_per_minggu')->default(1);
            $table->text('keterangan')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuti_rules');
    }
}; 