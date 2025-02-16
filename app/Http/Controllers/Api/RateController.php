<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RateController extends Controller
{
    /**
     * Get rates for a specific date or latest rates if no date provided.
     */
    public function index(Request $request): JsonResponse
    {
        $date = $request->input('date')
            ? Carbon::parse($request->input('date'))->format('Y-m-d')
            : Carbon::now()->format('Y-m-d');

        $rates = Rate::with(['baseCurrency:id,code,name', 'targetCurrency:id,code,name'])
            ->where('effective_date', $date)
            ->get()
            ->map(function ($rate) {
                return [
                    'id' => $rate->id,
                    'base_currency' => [
                        'code' => $rate->baseCurrency->code,
                        'name' => $rate->baseCurrency->name,
                    ],
                    'target_currency' => [
                        'code' => $rate->targetCurrency->code,
                        'name' => $rate->targetCurrency->name,
                    ],
                    'rate' => round($rate->rate, 4),
                    'effective_date' => $rate->effective_date->format('Y-m-d'),
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => [
                'date' => $date,
                'rates' => $rates
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
