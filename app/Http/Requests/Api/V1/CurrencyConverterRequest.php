<?php

namespace App\Http\Requests\Api\V1;


use App\Rules\RateExistsRule;

class CurrencyConverterRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $baseCurrencyCode = $this->get('base_currency');
        return [
            'base_currency' => ['required', 'max:3', 'min:3'],
            'dest_currency' => ['required', 'max:3', 'min:3', new RateExistsRule($baseCurrencyCode)],
            'amount' => ['required', 'numeric'],
        ];
    }
}
