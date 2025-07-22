<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CutiRule;

class CutiRuleSeeder extends Seeder
{
    public function run(): void
    {
        CutiRule::create([
            'nama_rule' => 'Aturan Cuti Standar',
            'max_cuti_per_minggu' => 1,
            'max_cuti_per_bulan' => 3,
            'jatah_libur_per_minggu' => 1,
            'keterangan' => 'Karyawan dapat cuti maksimal 1 kali per minggu, 3 kali per bulan, dan mendapat 1 hari libur per minggu',
            'aktif' => true
        ]);
    }
}
