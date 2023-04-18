<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Requests\V1\StoreCurrencyRequest;
use App\Http\Resources\V1\CurrencyCollection;

class CurrencyController extends Controller
{
    public function index(Request $request)
    {
        if ($request->date || $request->currency) {
            $currencies = Currency::query();

            if ($request->date) $currencies->where('date', $request->date);

            if ($request->currency) $currencies->where('currency', $request->currency);

            $currencies = $currencies->get();

            if (count($currencies) > 0) {
                return new CurrencyCollection($currencies);
            } else {
                return [
                    'message' => 'No currencies found'
                ];
            }
        } else {
            $currencies = Currency::all();

            if (count($currencies) > 0) {
                return new CurrencyCollection($currencies);
            } else {
                return [
                    'message' => 'No currencies in database'
                ];
            }
        }
    }

    public function store(StoreCurrencyRequest $request)
    {
        $currency = Currency::firstOrCreate([
            'currency' => strtoupper($request->currency),
            'date' => date('Y-m-d'),
            'amount' => $request->amount
        ]);

        if ($currency->wasRecentlyCreated) {
            return ['message' => 'Currency added'];
        } else {
            return ['message' => 'Currency amount for this day exists in database'];
        }
    }
}
