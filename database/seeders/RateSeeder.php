<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $today = Carbon::now()->format('Y-m-d');
        $historical = '2023-07-01';

        $rates = [
            // Current rates
            ['base_currency_id' => 1, 'target_currency_id' => 2, 'rate' => 0.85, 'effective_date' => $today],
            ['base_currency_id' => 1, 'target_currency_id' => 3, 'rate' => 0.73, 'effective_date' => $today],
            ['base_currency_id' => 1, 'target_currency_id' => 4, 'rate' => 110.25, 'effective_date' => $today],
            ['base_currency_id' => 1, 'target_currency_id' => 5, 'rate' => 1.35, 'effective_date' => $today],

            // Historical rates
            ['base_currency_id' => 1, 'target_currency_id' => 2, 'rate' => 0.81, 'effective_date' => $historical],
            ['base_currency_id' => 1, 'target_currency_id' => 3, 'rate' => 0.68, 'effective_date' => $historical],
            ['base_currency_id' => 1, 'target_currency_id' => 4, 'rate' => 109.31, 'effective_date' => $historical],
            ['base_currency_id' => 1, 'target_currency_id' => 5, 'rate' => 1.25, 'effective_date' => $historical],
        ];

        foreach ($rates as $rate) {
            DB::table('rates')->insert($rate);
        }
    }
}
