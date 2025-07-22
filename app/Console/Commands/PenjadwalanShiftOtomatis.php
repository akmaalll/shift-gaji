<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Shift;
use Carbon\Carbon;

class PenjadwalanShiftOtomatis extends Command
{
    protected $signature = 'shift:jadwal-otomatis {bulan?} {tahun?}';
    protected $description = 'Membuat jadwal shift otomatis untuk bulan tertentu';

    public function handle()
    {
        $bulan = $this->argument('bulan') ?? Carbon::now()->month;
        $tahun = $this->argument('tahun') ?? Carbon::now()->year;

        $tanggal = Carbon::create($tahun, $bulan, 1);
        $akhirBulan = $tanggal->copy()->endOfMonth();

        $this->info("Membuat jadwal shift untuk {$tanggal->format('F Y')}...");

        $shiftDibuat = 0;

        while ($tanggal->lte($akhirBulan)) {
            // Skip hari Minggu (0 = Sunday)
            if ($tanggal->dayOfWeek !== 0) {
                // Cek apakah shift sudah ada untuk tanggal ini
                $shiftPagi = Shift::where('tanggal_shift', $tanggal->format('Y-m-d'))
                    ->where('jenis_shift', 'pagi')
                    ->first();

                $shiftMalam = Shift::where('tanggal_shift', $tanggal->format('Y-m-d'))
                    ->where('jenis_shift', 'malam')
                    ->first();

                // Buat shift pagi jika belum ada
                if (!$shiftPagi) {
                    Shift::create([
                        'user_id' => null,
                        'tanggal_shift' => $tanggal->format('Y-m-d'),
                        'jenis_shift' => 'pagi',
                        'jam_mulai' => '07:30:00',
                        'jam_selesai' => '16:00:00',
                        'status' => 'kosong',
                        'keterangan' => 'Shift pagi - Belum diambil'
                    ]);
                    $shiftDibuat++;
                }

                // Buat shift malam jika belum ada
                if (!$shiftMalam) {
                    Shift::create([
                        'user_id' => null,
                        'tanggal_shift' => $tanggal->format('Y-m-d'),
                        'jenis_shift' => 'malam',
                        'jam_mulai' => '16:00:00',
                        'jam_selesai' => '24:00:00',
                        'status' => 'kosong',
                        'keterangan' => 'Shift malam - Belum diambil'
                    ]);
                    $shiftDibuat++;
                }
            }

            $tanggal->addDay();
        }

        $this->info("Berhasil membuat {$shiftDibuat} shift kosong untuk {$tanggal->format('F Y')}");

        return 0;
    }
}
