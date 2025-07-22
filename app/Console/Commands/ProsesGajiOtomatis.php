<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GajiRuleEngineService;

class ProsesGajiOtomatis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gaji:proses {bulan?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Proses perhitungan gaji otomatis berbasis rule untuk semua karyawan';

    /**
     * Execute the console command.
     */
    public function handle(GajiRuleEngineService $service)
    {
        $bulan = $this->argument('bulan');
        $service->prosesGajiBulan($bulan);
        $this->info('Proses gaji otomatis selesai.');
    }
}
