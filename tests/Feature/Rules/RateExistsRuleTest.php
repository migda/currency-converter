<?php

namespace Tests\Feature;

use App\Models\Currency;
use App\Models\ExchangeRate;
use App\Rules\RateExistsRule;
use Tests\TestCase;

class RateExistsRuleTest extends TestCase
{
    /**
     * Test passes method from RateExistsRule
     *
     * @return void
     */
    public function testBasicTest()
    {
        // Mock up currencies
        $currencies = factory(Currency::class, 2)->create();
        // Mock up exchange rate
        factory(ExchangeRate::class)->create(
            [
                'base_currency_id' => $currencies[0]->id,
                'dest_currency_id' => $currencies[1]->id,
            ]
        );
        // Tests
        $this->assertEquals(true, (new RateExistsRule($currencies[0]->code))->passes('dest', $currencies[1]->code));
        $this->assertEquals(false, (new RateExistsRule($currencies[1]->code))->passes('dest', $currencies[0]->code));
    }
}
