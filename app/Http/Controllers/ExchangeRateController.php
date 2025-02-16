<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\View\View;

class ExchangeRateController extends Controller
{
    /**
     * Display the exchange rates page.
     */
    public function index(): View
    {
        $currencies = Currency::all(['id', 'code', 'name']);

        return view('exchange-rates.index', [
            'currencies' => $currencies,
        ]);
    }
}
