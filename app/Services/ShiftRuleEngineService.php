<?php

namespace App\Services;

use App\Models\User;
use App\Models\Shift;
use App\Models\Cuti;
use App\Models\RuleShift;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ShiftRuleEngineService
{
    /**
     * Penjadwalan shift otomatis berdasarkan aturan yang ditetapkan
     *
     * @param string $tanggalMulai (opsional)
     * @param string $tanggalSelesai (opsional)
     * @return array
     */
    public function penjadwalanOtomatis()
    {
        $rule = RuleShift::where('aktif', true)->first();
        if (!$rule) {
            Log::error('Tidak ada rule shift yang aktif');
            return ['success' => false, 'message' => 'Tidak ada rule shift yang aktif'];
        }

        $users = User::where('role', 'karyawan')->get();
        if ($users->isEmpty()) {
            return ['success' => false, 'message' => 'Tidak ada karyawan yang tersedia'];
        }

        $assignedShifts = 0;
        $errors = [];

        // Ambil semua shift yang statusnya kosong, urutkan berdasarkan tanggal_shift
        $shiftsKosong = Shift::where('status', 'kosong')->orderBy('tanggal_shift')->get();
        foreach ($shiftsKosong as $shiftKosong) {
            // Jadwalkan shift kosong ini (gunakan jadwalkanHari untuk 1 hari saja)
            $date = \Carbon\Carbon::parse($shiftKosong->tanggal_shift);
            $result = $this->jadwalkanHari($date, $users, $rule);
            $assignedShifts += $result['assigned'];
            if (!empty($result['errors'])) {
                $errors = array_merge($errors, $result['errors']);
            }
        }

        return [
            'success' => true,
            'message' => "Berhasil menjadwalkan {$assignedShifts} shift kosong yang tersedia.",
            'assigned_shifts' => $assignedShifts,
            'errors' => $errors,
        ];
    }

    /**
     * Menjadwalkan shift untuk satu hari tertentu
     *
     * @param Carbon $date
     * @param \Illuminate\Support\Collection $users
     * @param RuleShift $rule
     * @return array
     */
    private function jadwalkanHari($date, $users, $rule)
    {
        $assigned = 0;
        $errors = [];

        // Skip hari Minggu (0 = Sunday)
        if ($date->dayOfWeek === 0) {
            return ['assigned' => 0, 'errors' => []];
        }

        // Definisikan shift untuk satu hari (pagi dan malam sesuai aturan)
        $shiftsPerDay = [
            ['jenis' => 'pagi', 'jam_mulai' => '07:30', 'jam_selesai' => '16:00'],
            ['jenis' => 'malam', 'jam_mulai' => '16:00', 'jam_selesai' => '24:00']
        ];

        foreach ($shiftsPerDay as $shiftInfo) {
            // Cek apakah shift sudah ada
            $existingShift = Shift::where('tanggal_shift', $date->format('Y-m-d'))
                ->where('jenis_shift', $shiftInfo['jenis'])
                ->first();

            if (!$existingShift) {
                // Buat shift baru jika belum ada
                $existingShift = Shift::create([
                    'tanggal_shift' => $date->format('Y-m-d'),
                    'jenis_shift' => $shiftInfo['jenis'],
                    'jam_mulai' => $shiftInfo['jam_mulai'],
                    'jam_selesai' => $shiftInfo['jam_selesai'],
                    'status' => 'kosong',
                    'keterangan' => 'Shift otomatis - Belum diambil'
                ]);
            }

            // Jika shift masih kosong, assign karyawan menggunakan algoritma rule-based
            if ($existingShift->status === 'kosong') {
                $assignedUser = $this->pilihKaryawanUntukShift($existingShift, $users, $rule);

                if ($assignedUser) {
                    $existingShift->user_id = $assignedUser->id;
                    $existingShift->status = 'diambil';
                    $existingShift->keterangan = 'Shift telah diambil oleh ' . $assignedUser->nama_lengkap;
                    $existingShift->save();
                    $assigned++;
                } else {
                    $errors[] = "Tidak ada karyawan yang tersedia untuk shift {$shiftInfo['jenis']} pada {$date->format('Y-m-d')}";
                }
            }
        }

        return ['assigned' => $assigned, 'errors' => $errors];
    }

    /**
     * Memilih karyawan yang paling sesuai untuk shift tertentu
     *
     * @param Shift $shift
     * @param \Illuminate\Support\Collection $users
     * @param RuleShift $rule
     * @return User|null
     */
    private function pilihKaryawanUntukShift($shift, $users, $rule)
    {
        $eligibleUsers = $users->filter(function ($user) use ($shift, $rule) {
            return $this->isKaryawanEligible($user, $shift, $rule);
        });

        if ($eligibleUsers->isEmpty()) {
            return null;
        }

        // Implementasi rotasi shift yang lebih fleksibel
        $weekNumber = Carbon::parse($shift->tanggal_shift)->weekOfYear;
        $shiftType = $shift->jenis_shift;

        // Urutkan berdasarkan prioritas rotasi
        $sortedUsers = $eligibleUsers->sortBy(function ($user) use ($shift, $weekNumber, $shiftType) {
            $score = 0;

            // 1. Prioritas: karyawan yang belum pernah shift di hari yang sama
            $hasShiftToday = Shift::where('user_id', $user->id)
                ->where('tanggal_shift', $shift->tanggal_shift)
                ->where('status', '!=', 'dibatalkan')
                ->exists();

            if ($hasShiftToday) {
                $score += 1000; // Sangat rendah prioritas
            }

            // 2. Rotasi shift berdasarkan minggu
            $lastShift = Shift::where('user_id', $user->id)
                ->where('tanggal_shift', '<', $shift->tanggal_shift)
                ->where('status', '!=', 'dibatalkan')
                ->orderByDesc('tanggal_shift')
                ->first();

            if ($lastShift) {
                $lastWeek = Carbon::parse($lastShift->tanggal_shift)->weekOfYear;
                $weekDiff = $weekNumber - $lastWeek;

                // Jika minggu yang sama, prioritas rendah
                if ($weekDiff == 0) {
                    $score += 500;
                }

                // Rotasi shift: jika minggu lalu malam, minggu ini prioritas pagi
                if ($lastShift->jenis_shift === 'malam' && $shiftType === 'pagi') {
                    $score -= 100; // Prioritas tinggi
                } elseif ($lastShift->jenis_shift === 'pagi' && $shiftType === 'malam') {
                    $score += 50; // Prioritas rendah
                }
            }

            // 3. Jumlah shift minggu ini (fairness) - lebih fleksibel
            $shiftCountThisWeek = Shift::where('user_id', $user->id)
                ->whereBetween('tanggal_shift', [
                    Carbon::parse($shift->tanggal_shift)->startOfWeek(Carbon::MONDAY)->format('Y-m-d'),
                    Carbon::parse($shift->tanggal_shift)->endOfWeek(Carbon::SUNDAY)->format('Y-m-d')
                ])
                ->whereIn('status', ['selesai', 'diambil'])
                ->count();

            $score += $shiftCountThisWeek * 5; // Skor lebih rendah untuk fairness

            // 4. Jeda dari shift terakhir - lebih fleksibel
            if ($lastShift) {
                $jeda = Carbon::parse($shift->tanggal_shift)->diffInDays(Carbon::parse($lastShift->tanggal_shift));
                if ($jeda < ($rule->min_jeda_hari ?? 0)) {
                    $score += 50; // Skor lebih rendah untuk jeda
                }
            }

            // 5. Cek aturan cuti: maksimal 1 cuti per minggu - lebih fleksibel
            $cutiThisWeek = Cuti::where('user_id', $user->id)
                ->where('status', 'disetujui')
                ->whereBetween('tanggal_mulai', [
                    Carbon::parse($shift->tanggal_shift)->startOfWeek()->format('Y-m-d'),
                    Carbon::parse($shift->tanggal_shift)->endOfWeek()->format('Y-m-d')
                ])
                ->count();

            if ($cutiThisWeek >= 1) {
                $score += 100; // Skor lebih rendah untuk cuti mingguan
            }

            // 6. Cek aturan cuti: maksimal 3 cuti per bulan - lebih fleksibel
            $cutiThisMonth = Cuti::where('user_id', $user->id)
                ->where('status', 'disetujui')
                ->whereMonth('tanggal_mulai', date('m', strtotime($shift->tanggal_shift)))
                ->whereYear('tanggal_mulai', date('Y', strtotime($shift->tanggal_shift)))
                ->count();

            if ($cutiThisMonth >= 3) {
                $score += 150; // Skor lebih rendah untuk cuti bulanan
            }

            return $score;
        });

        return $sortedUsers->first();
    }

    /**
     * Mengecek apakah karyawan eligible untuk shift tertentu
     *
     * @param User $user
     * @param Shift $shift
     * @param RuleShift $rule
     * @return bool
     */
    private function isKaryawanEligible($user, $shift, $rule)
    {
        // 1. Cek apakah sedang cuti
        $onLeave = Cuti::where('user_id', $user->id)
            ->where('tanggal_mulai', '<=', $shift->tanggal_shift)
            ->where('tanggal_selesai', '>=', $shift->tanggal_shift)
            ->where('status', 'disetujui')
            ->exists();

        if ($onLeave) {
            return false;
        }

        // 2. Cek apakah sudah ada shift di hari yang sama
        $hasShiftToday = Shift::where('user_id', $user->id)
            ->where('tanggal_shift', $shift->tanggal_shift)
            ->where('status', '!=', 'dibatalkan')
            ->exists();

        if ($hasShiftToday) {
            return false;
        }

        // 3. Cek jumlah shift minggu ini (maksimal 7 shift per minggu)
        $shiftCountThisWeek = Shift::where('user_id', $user->id)
            ->whereBetween('tanggal_shift', [
                Carbon::parse($shift->tanggal_shift)->startOfWeek(Carbon::MONDAY)->format('Y-m-d'),
                Carbon::parse($shift->tanggal_shift)->endOfWeek(Carbon::SUNDAY)->format('Y-m-d')
            ])
            ->whereIn('status', ['selesai', 'diambil'])
            ->count();

        if ($shiftCountThisWeek >= ($rule->max_shift_per_minggu ?? 7)) {
            return false;
        }

        // 4. Cek jeda minimum dari shift terakhir - lebih fleksibel
        $lastShift = Shift::where('user_id', $user->id)
            ->where('tanggal_shift', '<', $shift->tanggal_shift)
            ->where('status', '!=', 'dibatalkan')
            ->orderByDesc('tanggal_shift')
            ->first();

        if ($lastShift) {
            $jeda = Carbon::parse($shift->tanggal_shift)->diffInDays(Carbon::parse($lastShift->tanggal_shift));
            // Jika jeda kurang dari minimum, tetap eligible (hanya prioritas rendah)
            if ($jeda < ($rule->min_jeda_hari ?? 0)) {
                return true; // Tetap eligible, hanya prioritas rendah
            }
        }

        // 5. Cek aturan cuti: maksimal 1 cuti per minggu - lebih fleksibel
        $cutiThisWeek = Cuti::where('user_id', $user->id)
            ->where('status', 'disetujui')
            ->whereBetween('tanggal_mulai', [
                Carbon::parse($shift->tanggal_shift)->startOfWeek()->format('Y-m-d'),
                Carbon::parse($shift->tanggal_shift)->endOfWeek()->format('Y-m-d')
            ])
            ->count();

        // Jika sudah cuti minggu ini, tetap eligible (hanya prioritas rendah)
        if ($cutiThisWeek >= 1) {
            return true; // Tetap eligible, hanya prioritas rendah
        }

        // 6. Cek aturan cuti: maksimal 3 cuti per bulan - lebih fleksibel
        $cutiThisMonth = Cuti::where('user_id', $user->id)
            ->where('status', 'disetujui')
            ->whereMonth('tanggal_mulai', date('m', strtotime($shift->tanggal_shift)))
            ->whereYear('tanggal_mulai', date('Y', strtotime($shift->tanggal_shift)))
            ->count();

        // Jika sudah 3 cuti bulan ini, tetap eligible (hanya prioritas rendah)
        if ($cutiThisMonth >= 3) {
            return true; // Tetap eligible, hanya prioritas rendah
        }

        return true;
    }

    /**
     * Mendapatkan daftar shift kosong untuk ditampilkan ke karyawan
     *
     * @param string $tanggalMulai
     * @param string $tanggalSelesai
     * @return \Illuminate\Support\Collection
     */
    public function getShiftKosong($tanggalMulai = null, $tanggalSelesai = null)
    {
        $query = Shift::where('status', 'kosong');

        if ($tanggalMulai) {
            $query->where('tanggal_shift', '>=', $tanggalMulai);
        }
        if ($tanggalSelesai) {
            $query->where('tanggal_shift', '<=', $tanggalSelesai);
        }

        return $query->orderBy('tanggal_shift')->get();
    }

    /**
     * Mengecek apakah karyawan eligible untuk shift tertentu (public method)
     *
     * @param User $user
     * @param Shift $shift
     * @param RuleShift $rule
     * @return bool
     */
    public function checkKaryawanEligible($user, $shift, $rule)
    {
        return $this->isKaryawanEligible($user, $shift, $rule);
    }

    /**
     * Karyawan mengambil shift kosong
     *
     * @param int $shiftId
     * @param int $userId
     * @return array
     */
    public function ambilShiftKosong($shiftId, $userId)
    {
        $shift = Shift::find($shiftId);
        $user = User::find($userId);

        if (!$shift || !$user) {
            return ['success' => false, 'message' => 'Shift atau user tidak ditemukan'];
        }

        if ($shift->status !== 'kosong') {
            return ['success' => false, 'message' => 'Shift sudah tidak tersedia'];
        }

        // Cek eligibility
        $rule = RuleShift::where('aktif', true)->first();
        if (!$this->isKaryawanEligible($user, $shift, $rule)) {
            return ['success' => false, 'message' => 'Anda tidak eligible untuk shift ini'];
        }

        // Assign shift
        $shift->user_id = $userId;
        $shift->status = 'diambil';
        $shift->save();

        return ['success' => true, 'message' => 'Berhasil mengambil shift'];
    }

    /**
     * Validasi jadwal untuk memastikan tidak ada konflik
     *
     * @param string $tanggalMulai
     * @param string $tanggalSelesai
     * @return array
     */
    public function validasiJadwal($tanggalMulai = null, $tanggalSelesai = null)
    {
        $startDate = $tanggalMulai ? Carbon::parse($tanggalMulai) : Carbon::now()->startOfMonth();
        $endDate = $tanggalSelesai ? Carbon::parse($tanggalSelesai) : Carbon::now()->endOfMonth();

        $conflicts = [];

        // Cek setiap hari
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $shifts = Shift::where('tanggal_shift', $date->format('Y-m-d'))
                ->where('status', '!=', 'dibatalkan')
                ->get();

            // Cek apakah ada karyawan yang dijadwalkan lebih dari satu shift per hari
            $userShifts = $shifts->groupBy('user_id');
            foreach ($userShifts as $userId => $userShiftList) {
                if ($userShiftList->count() > 1) {
                    $user = User::find($userId);
                    $conflicts[] = [
                        'tanggal' => $date->format('Y-m-d'),
                        'user' => $user ? $user->nama_lengkap : "User ID: {$userId}",
                        'jumlah_shift' => $userShiftList->count(),
                        'jenis' => 'multiple_shifts_per_day'
                    ];
                }
            }

            // Cek apakah setiap shift minimal ada 2 karyawan (jika diperlukan)
            $shiftTypes = $shifts->groupBy('jenis_shift');
            foreach ($shiftTypes as $shiftType => $shiftList) {
                if ($shiftList->count() < 2) {
                    $conflicts[] = [
                        'tanggal' => $date->format('Y-m-d'),
                        'shift_type' => $shiftType,
                        'jumlah_karyawan' => $shiftList->count(),
                        'jenis' => 'insufficient_staff'
                    ];
                }
            }
        }

        return [
            'valid' => empty($conflicts),
            'conflicts' => $conflicts
        ];
    }
}
