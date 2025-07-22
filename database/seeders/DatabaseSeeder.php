<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            KaryawanSeeder::class,
            ShiftScheduleSeeder::class,
            CutiRuleSeeder::class,
            RuleGajiSeeder::class,
            RuleShiftSeeder::class,
            ShiftSeeder::class,
            CutiSeeder::class,
            KinerjaSeeder::class,
        ]);
    }
}
