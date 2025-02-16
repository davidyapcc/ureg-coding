<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            ['id' => 1, 'code' => 'USD', 'name' => 'US Dollar'],
            ['id' => 2, 'code' => 'EUR', 'name' => 'Euro'],
            ['id' => 3, 'code' => 'GBP', 'name' => 'British Pound'],
            ['id' => 4, 'code' => 'JPY', 'name' => 'Japanese Yen'],
            ['id' => 5, 'code' => 'AUD', 'name' => 'Australian Dollar'],
        ];

        foreach ($currencies as $currency) {
            DB::table('currencies')->insert($currency);
        }
    }
}
