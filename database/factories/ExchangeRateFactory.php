<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\ExchangeRate::class, function (Faker $faker) {
    return [
        'date' => $faker->date('Y-m-d'),
        'base_currency_id' => function () {
            return factory(\App\Models\Currency::class)->create()->id;
        },
        'dest_currency_id' => function () {
            return factory(\App\Models\Currency::class)->create()->id;
        },
        'exchange_rate' => sprintf("%01.4f", $faker->randomFloat(4, 0.0001, 100)),
    ];
});
