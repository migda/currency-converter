<?php

namespace Tests\Feature\Services;


use App\Models\ExchangeRate;
use App\Services\CurrencyConverterService;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class CurrencyConverterControllerTest extends TestCase
{
    protected $url = 'api/v1/converter';

    /**
     *
     */
    public function testConvert()
    {
        // Mock up exchange rates
        $exchangeRates = factory(ExchangeRate::class, 2)->create();

        // Tests
        $a = rand(1, 100);
        $p = (int)config('converter.precision');

        // #1 - failed
        $this->get($this->url)->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);

        // #2 - ok
        $url = $this->url . '?base_currency=' . $exchangeRates[0]->baseCurrency->code . '&dest_currency=' . $exchangeRates[0]->destCurrency->code . '&amount=' . $a;
        $expectedAmount1 = CurrencyConverterService::getConvertedAmountByExchangeRate($a, $exchangeRates[0]->exchange_rate, $p);

        $this->get($url)->assertStatus(JsonResponse::HTTP_OK)
            ->assertJson([
                'data' => [
                    'type' => 'currency-converter',
                    'amount_to_convert' => $a,
                    'currencies' => $exchangeRates[0]->baseCurrency->code . ' / ' . $exchangeRates[0]->destCurrency->code,
                    'exchange_rate' => $exchangeRates[0]->exchange_rate,
                    'exchange_rate_date' => $exchangeRates[0]->date,
                    'converted_amount' => $expectedAmount1
                ]
            ]);
    }
}