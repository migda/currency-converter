<?php

use App\Models\ExchangeRate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExchangeRateSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            ExchangeRate::query()->insert(['id' => 1, 'date' => '2018-06-15', 'base_currency_id' => 1, 'dest_currency_id' => 2, 'exchange_rate' => 4.2802]);
            ExchangeRate::query()->insert(['id' => 2, 'date' => '2018-06-15', 'base_currency_id' => 1, 'dest_currency_id' => 3, 'exchange_rate' => 3.6922]);
            ExchangeRate::query()->insert(['id' => 3, 'date' => '2018-06-15', 'base_currency_id' => 1, 'dest_currency_id' => 4, 'exchange_rate' => 4.8998]);
            ExchangeRate::query()->insert(['id' => 4, 'date' => '2018-06-18', 'base_currency_id' => 1, 'dest_currency_id' => 2, 'exchange_rate' => 4.2887]);
            ExchangeRate::query()->insert(['id' => 5, 'date' => '2018-06-18', 'base_currency_id' => 1, 'dest_currency_id' => 3, 'exchange_rate' => 3.7003]);
            ExchangeRate::query()->insert(['id' => 6, 'date' => '2018-06-18', 'base_currency_id' => 1, 'dest_currency_id' => 4, 'exchange_rate' => 4.9003]);
        });
    }
}
