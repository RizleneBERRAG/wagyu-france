<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnimalBatch;
use App\Models\ShopProduct;
use App\Services\AdminDashboardService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminAnimalController extends Controller
{
    public function index(AdminDashboardService $dashboard): View
    {
        return view('admin.animals.index', [
            'animals' => AnimalBatch::withCount('cuts')->latest()->get(),
            'activeSummary' => $dashboard->activeBatchSummary(),
        ]);
    }

    public function create(): View
    {
        return view('admin.animals.form', [
            'animal' => new AnimalBatch([
                'reference' => 'WF-' . now()->format('Y') . '-',
                'name' => 'Réserve Wagyu France · ',
                'status' => 'draft',
                'launch_threshold_percent' => 50,
            ]),
            'statuses' => AnimalBatch::STATUSES,
            'pageTitle' => 'Préparer un nouvel animal',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['is_active'] = $request->boolean('is_active');
        $data = $this->normalizePublicationState($data);

        $animal = DB::transaction(function () use ($data) {
            if ($data['is_active']) {
                AnimalBatch::query()->update(['is_active' => false]);
            }

            $animal = AnimalBatch::create($data);
            $this->copyDefaultCuts($animal);

            return $animal;
        });

        return redirect()
            ->route('admin.animals.show', $animal)
            ->with('success', 'Le nouvel animal a été créé avec ses pièces de référence.');
    }

    public function show(AnimalBatch $animal, AdminDashboardService $dashboard): View
    {
        $animal->load('cuts');
        $requested = $dashboard->requestedQuantities($animal);
        $availableTotal = (float) $animal->cuts->where('is_active', true)->sum('available_kg');
        $requestedTotal = $animal->cuts->where('is_active', true)->sum(
            fn ($cut) => min((float) $cut->available_kg, (float) ($requested[$cut->slug] ?? 0))
        );
        $progress = $availableTotal > 0 ? min(100, round(($requestedTotal / $availableTotal) * 100)) : 0;

        return view('admin.animals.show', [
            'animal' => $animal,
            'requestedByCut' => $requested,
            'availableTotal' => $availableTotal,
            'requestedTotal' => $requestedTotal,
            'progress' => $progress,
            'statuses' => AnimalBatch::STATUSES,
        ]);
    }

    public function edit(AnimalBatch $animal): View
    {
        return view('admin.animals.form', [
            'animal' => $animal,
            'statuses' => AnimalBatch::STATUSES,
            'pageTitle' => 'Modifier ' . $animal->reference,
        ]);
    }

    public function update(Request $request, AnimalBatch $animal): RedirectResponse
    {
        $data = $this->validatedData($request, $animal);
        $data['is_active'] = $request->boolean('is_active');
        $data = $this->normalizePublicationState($data, $animal);

        DB::transaction(function () use ($animal, $data) {
            if ($data['is_active']) {
                AnimalBatch::where('id', '!=', $animal->getKey())->update(['is_active' => false]);
            }

            $animal->update($data);
        });

        return back()->with('success', 'Les informations de l’animal ont été mises à jour.');
    }

    public function activate(AnimalBatch $animal): RedirectResponse
    {
        DB::transaction(function () use ($animal) {
            AnimalBatch::query()->update(['is_active' => false]);
            $animal->update([
                'is_active' => true,
                'status' => in_array($animal->status, ['draft', 'closed'], true) ? 'open' : $animal->status,
                'opens_at' => $animal->opens_at ?: now(),
                'closed_at' => null,
            ]);
        });

        return back()->with('success', $animal->reference . ' est maintenant l’animal publié dans la réserve.');
    }

    public function destroy(AnimalBatch $animal): RedirectResponse
    {
        if ($animal->is_active) {
            return back()->withErrors(['animal' => 'Désactivez cet animal avant de le supprimer.']);
        }

        $animal->delete();

        return redirect()->route('admin.animals.index')->with('success', 'L’animal et ses pièces ont été supprimés.');
    }

    private function validatedData(Request $request, ?AnimalBatch $animal = null): array
    {
        return $request->validate([
            'reference' => ['required', 'string', 'max:80', Rule::unique('animal_batches', 'reference')->ignore($animal?->id)],
            'name' => ['required', 'string', 'max:190'],
            'status' => ['required', Rule::in(array_keys(AnimalBatch::STATUSES))],
            'launch_threshold_percent' => ['required', 'integer', 'min:1', 'max:100'],
            'opens_at' => ['nullable', 'date'],
            'cutting_planned_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:3000'],
        ]);
    }

    private function normalizePublicationState(array $data, ?AnimalBatch $animal = null): array
    {
        if ($data['is_active'] && in_array($data['status'], ['draft', 'closed'], true)) {
            $data['status'] = 'open';
        }

        if ($data['is_active'] && empty($data['opens_at'])) {
            $data['opens_at'] = $animal?->opens_at ?: now();
        }

        if ($data['status'] === 'closed') {
            $data['closed_at'] = $animal?->closed_at ?: now();
            $data['is_active'] = false;
        } else {
            $data['closed_at'] = null;
        }

        return $data;
    }

    private function copyDefaultCuts(AnimalBatch $animal): void
    {
        $source = AnimalBatch::where('id', '!=', $animal->getKey())
            ->with('cuts')
            ->latest('id')
            ->first();

        if ($source && $source->cuts->isNotEmpty()) {
            foreach ($source->cuts as $cut) {
                $animal->cuts()->create($cut->only([
                    'slug',
                    'name',
                    'description',
                    'price_per_kg',
                    'available_kg',
                    'min_quantity_kg',
                    'is_active',
                    'sort_order',
                ]));
            }

            return;
        }

        ShopProduct::orderBy('sort_order')->get()->each(function (ShopProduct $product) use ($animal) {
            $animal->cuts()->create([
                'slug' => $product->slug,
                'name' => $product->name,
                'description' => $product->description,
                'price_per_kg' => $product->price_per_kg,
                'available_kg' => $product->stock_kg,
                'min_quantity_kg' => max(1, (float) $product->min_quantity_kg),
                'is_active' => true,
                'sort_order' => $product->sort_order,
            ]);
        });
    }
}
