<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CurrencyConverterRequest;
use App\Services\CurrencyConverterService;
use App\Transformers\Api\V1\CurrencyConverterTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;

class CurrencyConverterController extends Controller
{
    /**
     * @var CurrencyConverterService
     */
    protected $service;

    /**
     * @var Manager
     */
    protected $fractal;


    /**
     * CurrencyConverterController constructor.
     * @param CurrencyConverterService $service
     * @param Manager $fractal
     */
    public function __construct(CurrencyConverterService $service, Manager $fractal)
    {
        $this->service = $service;
        $this->fractal = $fractal;
    }

    /**
     * @param CurrencyConverterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function convert(CurrencyConverterRequest $request)
    {
        $amount = $this->service->getConvertedAmountByCurrencyCodes(
            $request->get('base_currency'),
            $request->get('dest_currency'),
            $request->get('amount')
        );
        $item = new Item($amount, new CurrencyConverterTransformer());
        $data = $this->fractal->createData($item)->toArray();
        return response()->json($data);
    }
}