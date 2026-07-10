<?php

namespace App\Http\Controllers;

use App\Services\AdminDashboardService;
use Illuminate\View\View;

class ReserveProController extends Controller
{
    public function index(AdminDashboardService $dashboard): View
    {
        $summary = $dashboard->activeBatchSummary();
        $batch = $summary['batch'] ?? null;

        $cuts = collect($summary['cuts'] ?? [])->mapWithKeys(function (array $cutSummary) {
            $cut = $cutSummary['model'];

            return [$cut->slug => [
                'name' => $cut->name,
                'description' => $cut->description,
                'price' => number_format((float) $cut->price_per_kg, 0, ',', ' ') . ' €/kg',
                'priceValue' => (float) $cut->price_per_kg,
                'stock' => number_format((float) $cut->available_kg, 1, ',', ' ') . ' kg',
                'stockValue' => (float) $cut->available_kg,
                'reserved' => $cutSummary['progress'] . '%',
                'min' => number_format((float) $cut->min_quantity_kg, 1, ',', ' ') . ' kg',
                'minValue' => (float) $cut->min_quantity_kg,
                'percent' => $cutSummary['progress'],
            ]];
        })->all();

        return view('pages.reserve-pro', [
            'activeBatch' => $batch,
            'reserveSummary' => $summary,
            'reserveCuts' => $cuts,
        ]);
    }
}
