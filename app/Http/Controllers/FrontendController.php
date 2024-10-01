<?php

namespace App\Http\Controllers;

class FrontendController extends Controller
{
    /**
     * Display the home page.
     */
    public function home()
    {
        return view('pages.home');
    }

    /**
     * Display the exchange rates page.
     */
    public function exchangeRates()
    {
        return view('pages.exchange-rates');
    }

}
