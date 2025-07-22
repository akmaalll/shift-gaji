<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RuleShift;

class ShiftRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus rule yang ada
        RuleShift::truncate();

        // Buat rule shift berdasarkan aturan yang ditetapkan
        RuleShift::create([
            'nama_rule' => 'Aturan Penjadwalan Shift Standar',
            'deskripsi' => 'Aturan penjadwalan shift dengan rotasi mingguan dan fairness',
            'max_shift_per_bulan' => 25, // Maksimal 25 shift per bulan
            'min_jeda_hari' => 0, // Minimal jeda 0 hari (bisa shift berturut-turut)
            'min_karyawan_per_shift' => 2, // Minimal 2 karyawan per shift
            'rotasi_mingguan' => true, // Aktifkan rotasi mingguan
            'fairness' => true, // Aktifkan fairness dalam pembagian shift
            'prioritas_shift_malam' => true, // Prioritas untuk shift malam
            'aktif' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Rule alternatif untuk shift malam
        RuleShift::create([
            'nama_rule' => 'Aturan Shift Malam Khusus',
            'deskripsi' => 'Aturan khusus untuk shift malam dengan jeda lebih lama',
            'max_shift_per_bulan' => 20, // Lebih sedikit shift untuk shift malam
            'min_jeda_hari' => 1, // Minimal jeda 1 hari setelah shift malam
            'min_karyawan_per_shift' => 2,
            'rotasi_mingguan' => true,
            'fairness' => true,
            'prioritas_shift_malam' => true,
            'aktif' => false, // Tidak aktif, hanya sebagai alternatif
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Rule untuk periode sibuk
        RuleShift::create([
            'nama_rule' => 'Aturan Periode Sibuk',
            'deskripsi' => 'Aturan untuk periode sibuk dengan shift lebih banyak',
            'max_shift_per_bulan' => 30, // Lebih banyak shift di periode sibuk
            'min_jeda_hari' => 0,
            'min_karyawan_per_shift' => 3, // Lebih banyak karyawan per shift
            'rotasi_mingguan' => true,
            'fairness' => true,
            'prioritas_shift_malam' => false, // Tidak ada prioritas khusus
            'aktif' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $this->command->info('Rule shift berhasil dibuat!');
        $this->command->info('Rule aktif: Aturan Penjadwalan Shift Standar');
    }
}
