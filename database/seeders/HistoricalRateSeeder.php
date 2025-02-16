<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HistoricalRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $baseRates = [
            2 => 0.85,
            3 => 0.73,
            4 => 110.25,
            5 => 1.35,
            6 => 1.25,
            7 => 0.92,
            8 => 6.45,
            9 => 1.32,
            10 => 1.55,
        ];

        $startDate = Carbon::create(2025, 2, 1);
        $endDate = Carbon::create(2025, 2, 14);

        while ($startDate <= $endDate) {
            foreach ($baseRates as $currencyId => $baseRate) {
                $variation = $baseRate * (rand(-50, 50) / 10000);
                $rate = $baseRate + $variation;

                DB::table('rates')->insert([
                    'base_currency_id' => 1,
                    'target_currency_id' => $currencyId,
                    'rate' => round($rate, 6),
                    'effective_date' => $startDate->format('Y-m-d'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $startDate->addDay();
        }
    }
}
