<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnimalBatch;
use App\Models\AnimalCut;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminAnimalCutController extends Controller
{
    public function update(Request $request, AnimalBatch $animal, AnimalCut $cut): RedirectResponse
    {
        abort_unless($cut->animal_batch_id === $animal->id, 404);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:190'],
            'description' => ['nullable', 'string', 'max:1200'],
            'price_per_kg' => ['required', 'numeric', 'min:0', 'max:99999'],
            'available_kg' => ['required', 'numeric', 'min:0', 'max:99999'],
            'min_quantity_kg' => ['required', 'numeric', 'min:0.1', 'max:999'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $cut->update($data);

        return back()->with('success', 'La pièce ' . $cut->name . ' a été mise à jour.');
    }
}
