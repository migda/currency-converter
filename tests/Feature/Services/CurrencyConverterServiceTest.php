<?php

namespace Tests\Feature\Services;


use App\Models\ExchangeRate;
use App\Services\CurrencyConverterService;
use Tests\TestCase;

class CurrencyConverterServiceTest extends TestCase
{
    /**
     * @var CurrencyConverterService
     */
    protected $service;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();
        $this->service = new CurrencyConverterService();
    }

    /**
     *
     */
    public function testGetConvertedAmountByCurrencyIds()
    {
        // Mock up exchange rates
        $exchangeRates = factory(ExchangeRate::class, 2)->create([
            'date' => '2018-10-02'
        ]);

        // Newer
        $exchangeRate0 = factory(ExchangeRate::class)->create(
            [
                'date' => '2018-10-03',
                'base_currency_id' => $exchangeRates[0]->base_currency_id,
                'dest_currency_id' => $exchangeRates[0]->dest_currency_id
            ]
        );

        // Older

        $exchangeRate1 = factory(ExchangeRate::class)->create(
            [
                'date' => '2018-10-01',
                'base_currency_id' => $exchangeRates[1]->base_currency_id,
                'dest_currency_id' => $exchangeRates[1]->dest_currency_id
            ]
        );

        // Tests
        $a = rand(1, 100);
        $p = rand(1, 6);

        #1 Newer
        $amountData1 = $this->service->getConvertedAmountByCurrencyCodes($exchangeRates[0]->baseCurrency->code, $exchangeRates[0]->destCurrency->code, $a, $p);
        $expectedAmount1 = CurrencyConverterService::getConvertedAmountByExchangeRate($a, $exchangeRate0->exchange_rate, $p);
        $this->assertEquals($expectedAmount1, $amountData1['converted_amount']);
        $this->assertEquals($exchangeRate0->date, $amountData1['exchange_rate_date']);
        $this->assertEquals($exchangeRate0->exchange_rate, $amountData1['exchange_rate']);

        $amountData1 = $this->service->getConvertedAmountByCurrencyCodes($exchangeRates[1]->baseCurrency->code, $exchangeRates[1]->destCurrency->code, $a, $p);
        $expectedAmount2 = CurrencyConverterService::getConvertedAmountByExchangeRate($a, $exchangeRates[1]->exchange_rate, $p);
        #1 Older
        $this->assertEquals($expectedAmount2, $amountData1['converted_amount']);
        $this->assertEquals($exchangeRates[1]->date, $amountData1['exchange_rate_date']);
        $this->assertEquals($exchangeRates[1]->exchange_rate, $amountData1['exchange_rate']);


    }
}