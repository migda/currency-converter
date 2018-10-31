<?php

namespace App\Services;


use App\Models\Currency;
use App\Models\ExchangeRate;

class CurrencyConverterService
{
    /**
     * @param string $baseCurrencyCode
     * @param string $destCurrencyCode
     * @param string $amountToConvert
     * @param int|null $precision
     * @return array
     */
    public function getConvertedAmountByCurrencyCodes(string $baseCurrencyCode, string $destCurrencyCode,
                                                      string $amountToConvert, int $precision = null): array
    {
        $amountToConvert = (float)$amountToConvert;
        $baseCurrency = Currency::query()->code($baseCurrencyCode)->firstOrFail();
        $destCurrency = Currency::query()->code($destCurrencyCode)->firstOrFail();
        $rate = ExchangeRate::query()->newestRate($baseCurrency->id, $destCurrency->id)->firstOrFail();
        // Get amount
        $amount = self::getConvertedAmountByExchangeRate($amountToConvert, $rate->exchange_rate, $precision);

        return [
            'amount_to_convert' => $amountToConvert,
            'currency_from' => $baseCurrency->code,
            'currency_to' => $destCurrency->code,
            'exchange_rate' => $rate->exchange_rate,
            'exchange_rate_date' => $rate->date,
            'converted_amount' => $amount
        ];
    }

    /**
     * @param float $amountToConvert
     * @param float $exchangeRate
     * @param int|null $precision
     * @return float
     */
    public static function getConvertedAmountByExchangeRate(float $amountToConvert, float $exchangeRate, int $precision = null): float
    {
        $precision = $precision ?: (int)config('converter.precision');
        return round($amountToConvert * $exchangeRate, $precision);
    }
}