<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RuleShift;

class RuleShiftSeeder extends Seeder
{
    public function run(): void
    {
        RuleShift::create([
            'nama_rule' => 'Aturan Shift Standar',
            'deskripsi' => 'Aturan shift standar dengan maksimal 7 shift per minggu, 1 shift per hari, dan tidak ada jeda minimum',
            'max_shift_per_minggu' => 7,
            'min_jeda_hari' => 0,
            'fairness' => true,
            'aktif' => true
        ]);
    }
}
