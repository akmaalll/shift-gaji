<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ShiftRuleEngineService;

class TestPenjadwalanOtomatis extends Command
{
    protected $signature = 'shift:test-penjadwalan';
    protected $description = 'Test penjadwalan shift otomatis dengan rule-based system';

    public function handle(ShiftRuleEngineService $shiftService)
    {
        $this->info('Testing penjadwalan shift otomatis...');

        try {
            $result = $shiftService->penjadwalanOtomatis();

            if ($result['success']) {
                $this->info('✅ ' . $result['message']);
                $this->info('📊 Shift yang dijadwalkan: ' . $result['assigned_shifts']);

                if (!empty($result['errors'])) {
                    $this->warn('⚠️  Beberapa error:');
                    foreach ($result['errors'] as $error) {
                        $this->line('   - ' . $error);
                    }
                }
            } else {
                $this->error('❌ ' . $result['message']);
            }

            // Tampilkan hasil
            $this->info("\n📋 Hasil penjadwalan:");
            $shifts = \App\Models\Shift::with('user')->orderBy('tanggal_shift')->get();

            if ($shifts->isEmpty()) {
                $this->warn('Tidak ada shift yang dibuat');
            } else {
                $this->table(
                    ['Tanggal', 'Jenis', 'Jam', 'Karyawan', 'Status'],
                    $shifts->map(function ($shift) {
                        return [
                            $shift->tanggal_shift,
                            ucfirst($shift->jenis_shift),
                            ($shift->jam_mulai ? $shift->jam_mulai->format('H:i') : '-') . ' - ' . ($shift->jam_selesai ? $shift->jam_selesai->format('H:i') : '-'),
                            $shift->user ? $shift->user->nama_lengkap : '-',
                            $shift->status
                        ];
                    })
                );
            }
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
        }

        return 0;
    }
}
