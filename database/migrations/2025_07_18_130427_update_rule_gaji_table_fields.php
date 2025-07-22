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
            $table->integer('jam_normal')->nullable();
            $table->integer('rate_normal')->nullable();
            $table->integer('rate_lembur')->nullable();
            $table->dropColumn('parameter');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rule_gaji', function (Blueprint $table) {
            $table->json('parameter')->nullable();
            $table->dropColumn(['jam_normal', 'rate_normal', 'rate_lembur']);
        });
    }
};
