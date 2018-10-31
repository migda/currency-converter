<?php

namespace Tests\Unit\Services;


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
    public function testGetConvertedAmountByExchangeRate()
    {
        $val1 = $this->service->getConvertedAmountByExchangeRate(1, 2, 2);
        $val2 = $this->service->getConvertedAmountByExchangeRate(0.21, 0.001, 2);
        $val3 = $this->service->getConvertedAmountByExchangeRate(0.21, 0.001, 5);
        $val4 = $this->service->getConvertedAmountByExchangeRate(1000.52, 4.9003, 4);

        $defaultPrecision = (int)config('converter.precision');
        $a = 231.1231;
        $b = 4.501;
        $val5 = $this->service->getConvertedAmountByExchangeRate($a, $b);
        $expectedValue5 = round($a * $b, $defaultPrecision);

        $this->assertEquals(2, $val1);
        $this->assertEquals(0, $val2);
        $this->assertEquals(0.00021, $val3);
        $this->assertEquals(4902.8482, $val4);
        $this->assertEquals($expectedValue5, $val5);
    }
}