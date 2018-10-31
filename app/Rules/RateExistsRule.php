<?php

namespace App\Rules;

use App\Models\Currency;
use App\Models\ExchangeRate;
use Illuminate\Contracts\Validation\Rule;

class RateExistsRule implements Rule
{
    /**
     * @var string
     */
    protected $baseCurrencyCode;

    /**
     * RateExistsRule constructor.
     * @param string $baseCurrencyCode
     */
    public function __construct(string $baseCurrencyCode = null)
    {
        $this->baseCurrencyCode = $baseCurrencyCode;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $destCurrencyCode
     * @return bool
     */
    public function passes($attribute, $destCurrencyCode)
    {
        $baseCurrency = Currency::query()->code($this->baseCurrencyCode)->first();
        if (!$baseCurrency)
            return false;
        $destCurrency = Currency::query()->code($destCurrencyCode)->first();
        if (!$destCurrency)
            return false;
        $exchangeRate = ExchangeRate::query()->baseCurrency($baseCurrency->id)->destCurrency($destCurrency->id)->first();
        if (!$exchangeRate)
            return false;
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.rate_exists');
    }
}
