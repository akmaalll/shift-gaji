<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RuleGaji;

class RuleGajiSeeder extends Seeder
{
    public function run(): void
    {
        RuleGaji::create([
            'nama_rule' => 'Gaji Berdasarkan Shift',
            'deskripsi' => '1 shift = Rp 50.000, dengan jam kerja 12 jam per shift',
            'gaji_per_shift' => 50000,
            'jam_kerja_per_shift' => 12,
            'rate_lembur_per_jam' => 50000/12, // 50000/8 = 6250
            'aktif' => true,
        ]);
    }
}
