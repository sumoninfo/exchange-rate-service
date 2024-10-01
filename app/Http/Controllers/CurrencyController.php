<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\CurrencyHistory;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a paginated list of currencies.
     */
    public function index(Request $request)
    {
        $currencies = Currency::query()->paginate($request->input('limit', 20));

        return response()->json([
            'data' => $currencies,
            'status' => true
        ], 200);
    }

    /**
     * Show details of a specific currency including its history.
     */
    public function show(Currency $currency)
    {
        return response()->json([
            'data' => $currency->with('histories')->first(),
            'status' => true
        ]);
    }

    /**
     * Display the history of a specific currency by ID.
     */
    public function history($id)
    {
        $currencyHistories = CurrencyHistory::query()->where('currency_id', $id)->get();
        return response()->json([
            'data' => $currencyHistories,
            'status' => true
        ]);
    }

}
