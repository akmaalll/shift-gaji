<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ShiftRuleEngineService;

class TestShiftScheduling extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shift:test-scheduling {--start=} {--end=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test shift scheduling for different date ranges';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $startDate = $this->option('start') ?: '2024-08-01';
        $endDate = $this->option('end') ?: '2024-08-31';

        $this->info("Testing shift scheduling from {$startDate} to {$endDate}");

        $service = new ShiftRuleEngineService();
        $result = $service->penjadwalanOtomatis($startDate, $endDate);

        if ($result['success']) {
            $this->info("✅ Success: " . $result['message']);
            $this->info("📊 Assigned shifts: " . $result['assigned_shifts']);

            if (!empty($result['periode'])) {
                $this->info("📅 Period: " . $result['periode']['mulai'] . " to " . $result['periode']['selesai']);
            }

            if (!empty($result['errors'])) {
                $this->warn("⚠️  Errors:");
                foreach ($result['errors'] as $error) {
                    $this->warn("   - " . $error);
                }
            }
        } else {
            $this->error("❌ Failed: " . $result['message']);
        }

        // Show some sample shifts
        $this->info("\n📋 Sample shifts created:");
        $shifts = \App\Models\Shift::whereBetween('tanggal_shift', [$startDate, $endDate])
            ->orderBy('tanggal_shift')
            ->limit(10)
            ->get();

        if ($shifts->count() > 0) {
            $this->table(
                ['Date', 'Type', 'Employee', 'Status'],
                $shifts->map(function ($shift) {
                    return [
                        $shift->tanggal_shift,
                        $shift->jenis_shift,
                        $shift->user ? $shift->user->nama_lengkap : 'Kosong',
                        $shift->status
                    ];
                })
            );
        } else {
            $this->warn("No shifts found for the specified period.");
        }
    }
}
