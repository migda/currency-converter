<?php

namespace App\Transformers\Api\V1;

use League\Fractal\TransformerAbstract;

class CurrencyConverterTransformer extends TransformerAbstract
{
    /**
     * @param array $convertedAmount
     * @return array
     */
    public function transform(array $convertedAmount)
    {
        return [
            'type' => 'currency-converter',
            'amount_to_convert' => $convertedAmount['amount_to_convert'],
            'currencies' => $convertedAmount['currency_from'] . ' / ' . $convertedAmount['currency_to'],
            'exchange_rate' => $convertedAmount['exchange_rate'],
            'exchange_rate_date' => $convertedAmount['exchange_rate_date'],
            'converted_amount' => $convertedAmount['converted_amount']
        ];
    }
}