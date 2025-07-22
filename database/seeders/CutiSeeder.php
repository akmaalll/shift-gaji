<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cuti;
use Carbon\Carbon;

class CutiSeeder extends Seeder
{
    public function run(): void
    {
        $tanggal = Carbon::now()->startOfMonth();

        // Karyawan 1 cuti 2 hari
        $tanggalMulai1 = $tanggal->copy()->addDays(1);
        $tanggalSelesai1 = $tanggal->copy()->addDays(2);
        $durasi1 = $tanggalMulai1->diffInDays($tanggalSelesai1) + 1;

        Cuti::create([
            'user_id' => 2,
            'tanggal_mulai' => $tanggalMulai1,
            'tanggal_selesai' => $tanggalSelesai1,
            'durasi' => $durasi1,
            'alasan' => 'Cuti tahunan',
            'status' => 'disetujui',
        ]);

        // Karyawan 2 cuti 1 hari
        $tanggalMulai2 = $tanggal->copy()->addDays(5);
        $tanggalSelesai2 = $tanggal->copy()->addDays(5);
        $durasi2 = $tanggalMulai2->diffInDays($tanggalSelesai2) + 1;

        Cuti::create([
            'user_id' => 3,
            'tanggal_mulai' => $tanggalMulai2,
            'tanggal_selesai' => $tanggalSelesai2,
            'durasi' => $durasi2,
            'alasan' => 'Cuti sakit',
            'status' => 'disetujui',
        ]);
    }
}
