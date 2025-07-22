<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShiftSchedule;

class ShiftScheduleSeeder extends Seeder
{
    public function run(): void
    {
        // Shift Pagi: 07:30 - 16:00
        ShiftSchedule::create([
            'nama_shift' => 'pagi',
            'jam_mulai' => '07:30:00',
            'jam_selesai' => '16:00:00',
            'keterangan' => 'Shift pagi dari jam 07:30 sampai 16:00',
            'aktif' => true
        ]);

        // Shift Malam: 16:00 - 24:00
        ShiftSchedule::create([
            'nama_shift' => 'malam',
            'jam_mulai' => '16:00:00',
            'jam_selesai' => '24:00:00',
            'keterangan' => 'Shift malam dari jam 16:00 sampai 24:00',
            'aktif' => true
        ]);
    }
} 