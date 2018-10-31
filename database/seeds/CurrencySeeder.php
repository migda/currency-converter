<?php

use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            Currency::query()->insert(['id' => 1, 'code' => 'PLN']);
            Currency::query()->insert(['id' => 2, 'code' => 'EUR']);
            Currency::query()->insert(['id' => 3, 'code' => 'USD']);
            Currency::query()->insert(['id' => 4, 'code' => 'GBP']);
        });
    }
}
