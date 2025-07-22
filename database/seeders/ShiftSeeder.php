<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shift;
use App\Models\User;
use Carbon\Carbon;

class ShiftSeeder extends Seeder
{
    public function run(): void
    {
        $karyawan = User::where('role', 'karyawan')->first();
        $tanggal = Carbon::now()->startOfMonth();

        // Buat shift untuk 1 bulan (30 hari)
        for ($i = 0; $i < 30; $i++) {
            $currentDate = $tanggal->copy()->addDays($i);

            // Skip hari Minggu (0 = Sunday)
            if ($currentDate->dayOfWeek === 0) {
                continue;
            }

            $status = ($i < 7) ? 'diambil' : 'kosong';
            $user_id = ($i < 7) ? $karyawan->id : null;
            $keterangan = ($i < 7) ? 'Shift diambil oleh karyawan' : 'Shift belum diambil';

            // Shift Pagi
            Shift::create([
                'user_id' => $user_id,
                'tanggal_shift' => $currentDate->format('Y-m-d'),
                'jenis_shift' => 'pagi',
                'jam_mulai' => '07:30:00',
                'jam_selesai' => '16:00:00',
                'status' => $status,
                'keterangan' => $keterangan
            ]);

            // Shift Malam
            Shift::create([
                'user_id' => $user_id,
                'tanggal_shift' => $currentDate->format('Y-m-d'),
                'jenis_shift' => 'malam',
                'jam_mulai' => '16:00:00',
                'jam_selesai' => '24:00:00',
                'status' => $status,
                'keterangan' => $keterangan
            ]);
        }
    }
}
