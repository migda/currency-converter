<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExchangeRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->engine = ' InnoDB';
            $table->increments('id');
            $table->date('date');
            $table->unsignedInteger('base_currency_id');
            $table->unsignedInteger('dest_currency_id');
            $table->unsignedDecimal('exchange_rate', 10, 4);
            // Indexes
            $table->index('base_currency_id', 'fk_exchange_rates_currencies1_idx');
            $table->index('dest_currency_id', 'fk_exchange_rates_currencies2_idx');
            // Keys
            $table->foreign('base_currency_id', 'fk_exchange_rates_currencies1')->references('id')->on('currencies');
            $table->foreign('dest_currency_id', 'fk_exchange_rates_currencies2')->references('id')->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exchange_rates');
    }
}
