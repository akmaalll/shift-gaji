<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kinerja;
use Carbon\Carbon;

class KinerjaSeeder extends Seeder
{
    public function run(): void
    {
        $tanggal = Carbon::now()->startOfMonth();
        // Karyawan 1
        Kinerja::create([
            'user_id' => 2,
            'tanggal' => $tanggal->copy()->addDays(3),
            'deskripsi' => 'Tepat waktu',
            'nilai' => 90,
        ]);
        Kinerja::create([
            'user_id' => 2,
            'tanggal' => $tanggal->copy()->addDays(10),
            'deskripsi' => 'Lembur',
            'nilai' => 95,
        ]);
        // Karyawan 2
        Kinerja::create([
            'user_id' => 3,
            'tanggal' => $tanggal->copy()->addDays(4),
            'deskripsi' => 'Tugas selesai',
            'nilai' => 88,
        ]);
        Kinerja::create([
            'user_id' => 3,
            'tanggal' => $tanggal->copy()->addDays(11),
            'deskripsi' => 'Kerja tim',
            'nilai' => 92,
        ]);
    }
}
