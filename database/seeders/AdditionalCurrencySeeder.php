<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdditionalCurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            ['id' => 6, 'code' => 'CAD', 'name' => 'Canadian Dollar'],
            ['id' => 7, 'code' => 'CHF', 'name' => 'Swiss Franc'],
            ['id' => 8, 'code' => 'CNY', 'name' => 'Chinese Yuan'],
            ['id' => 9, 'code' => 'SGD', 'name' => 'Singapore Dollar'],
            ['id' => 10, 'code' => 'NZD', 'name' => 'New Zealand Dollar'],
        ];

        foreach ($currencies as $currency) {
            DB::table('currencies')->insert($currency);
        }
    }
}
