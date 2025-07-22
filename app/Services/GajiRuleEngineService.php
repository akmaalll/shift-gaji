<?php

namespace App\Services;

use App\Models\User;
use App\Models\Shift;
use App\Models\Gaji;
use App\Models\RuleGaji;

class GajiRuleEngineService
{
    /**
     * Proses perhitungan gaji otomatis untuk semua karyawan pada bulan tertentu.
     *
     * @param string $bulan Format: YYYY-MM
     * @return void
     */
    public function prosesGajiBulan($bulan = null)
    {
        $bulan = $bulan ?: date('Y-m');
        $rule = RuleGaji::where('aktif', true)->first();
        if (!$rule) return;

        $gajiPerShift = $rule->gaji_per_shift;
        $jamKerjaPerShift = $rule->jam_kerja_per_shift;
        $rateLemburPerJam = $rule->rate_lembur_per_jam;

        $users = User::where('role', 'karyawan')->get();
        foreach ($users as $user) {
            $shifts = Shift::where('user_id', $user->id)
                ->where('status', 'selesai')
                ->where('tanggal_shift', 'like', "$bulan%")
                ->get();

            $totalShift = $shifts->count();
            $totalJamLembur = 0;
            $totalGaji = 0;
            $detail = [];

            foreach ($shifts as $shift) {
                $jamMulai = $shift->jam_mulai ? \Carbon\Carbon::parse($shift->jam_mulai) : null;
                $jamSelesai = $shift->jam_selesai ? \Carbon\Carbon::parse($shift->jam_selesai) : null;

                if ($jamMulai && $jamSelesai) {
                    $jamKerja = $jamMulai->diffInHours($jamSelesai);
                } else {
                    $jamKerja = 0;
                }

                // Gaji dasar per shift
                $gajiShift = $gajiPerShift;

                // Hitung lembur jika jam kerja melebihi jam kerja per shift
                $jamLembur = 0;
                if ($jamKerja > $jamKerjaPerShift) {
                    $jamLembur = $jamKerja - $jamKerjaPerShift;
                    $totalJamLembur += $jamLembur;
                }

                $gajiLembur = $jamLembur * $rateLemburPerJam;
                $totalGajiShift = $gajiShift + $gajiLembur;
                $totalGaji += $totalGajiShift;

                $detail[] = [
                    'tanggal' => $shift->tanggal_shift->format('d-m-Y'),
                    'jam_kerja' => $jamKerja,
                    'jam_lembur' => $jamLembur,
                    'gaji_per_shift' => $gajiShift,
                    'gaji_lembur' => $gajiLembur,
                    'total_gaji_shift' => $totalGajiShift,
                ];
                // dd($detail);
            }

            Gaji::updateOrCreate(
                ['user_id' => $user->id, 'bulan' => $bulan],
                [
                    'total_shift' => $totalShift,
                    'total_jam_lembur' => $totalJamLembur,
                    'total_gaji' => $totalGaji,
                    'detail_perhitungan' => $detail,
                ]
            );
        }
    }
}
