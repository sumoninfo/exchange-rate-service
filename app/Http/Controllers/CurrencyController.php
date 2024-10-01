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
        return Currency::query()->paginate($request->input('limit', 20));
    }

    /**
     * Show details of a specific currency including its history.
     */
    public function show(Currency $currency)
    {
        return $currency->with('histories');
    }

    /**
     * Display the history of a specific currency by ID.
     */
    public function history($id)
    {
        return CurrencyHistory::query()->where('currency_id', $id)->get();
    }

}
