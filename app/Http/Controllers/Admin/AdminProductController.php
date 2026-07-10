<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShopProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = ShopProduct::query()->orderBy('sort_order')->orderBy('name');

        if ($search = trim((string) $request->query('q'))) {
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        if ($request->query('status') === 'active') {
            $query->where('is_active', true);
        } elseif ($request->query('status') === 'hidden') {
            $query->where('is_active', false);
        } elseif ($request->query('status') === 'low') {
            $query->where('is_active', true)->whereColumn('stock_kg', '<=', 'low_stock_threshold');
        }

        return view('admin.products.index', [
            'products' => $query->get(),
            'totalProducts' => ShopProduct::count(),
            'activeProducts' => ShopProduct::where('is_active', true)->count(),
            'lowStockProducts' => ShopProduct::where('is_active', true)
                ->whereColumn('stock_kg', '<=', 'low_stock_threshold')
                ->count(),
        ]);
    }

    public function create(): View
    {
        return view('admin.products.form', [
            'product' => new ShopProduct([
                'is_active' => true,
                'min_quantity_kg' => 1,
                'low_stock_threshold' => 2,
                'sort_order' => (ShopProduct::max('sort_order') ?? 0) + 10,
            ]),
            'pageTitle' => 'Ajouter un produit',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['image_path'] = $this->storeImage($request);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        $product = ShopProduct::create($data);

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('success', 'Le produit a été ajouté à la boutique.');
    }

    public function edit(ShopProduct $product): View
    {
        return view('admin.products.form', [
            'product' => $product,
            'pageTitle' => 'Modifier ' . $product->name,
        ]);
    }

    public function update(Request $request, ShopProduct $product): RedirectResponse
    {
        $data = $this->validatedData($request, $product);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $this->deleteStoredImage($product->image_path);
            $data['image_path'] = $this->storeImage($request);
        }

        $product->update($data);

        return back()->with('success', 'Le produit a été mis à jour.');
    }

    public function toggle(ShopProduct $product): RedirectResponse
    {
        $product->update(['is_active' => ! $product->is_active]);

        return back()->with('success', $product->is_active
            ? 'Le produit est maintenant visible.'
            : 'Le produit est maintenant masqué.');
    }

    public function destroy(ShopProduct $product): RedirectResponse
    {
        $this->deleteStoredImage($product->image_path);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Le produit a été supprimé.');
    }

    private function validatedData(Request $request, ?ShopProduct $product = null): array
    {
        $productId = $product?->id;

        return $request->validate([
            'name' => ['required', 'string', 'max:190'],
            'slug' => ['required', 'alpha_dash', 'max:120', Rule::unique('shop_products', 'slug')->ignore($productId)],
            'reference' => ['nullable', 'string', 'max:190'],
            'badge' => ['nullable', 'string', 'max:80'],
            'category_label' => ['nullable', 'string', 'max:190'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['string', Rule::in(['noble', 'grill', 'caractere', 'lent'])],
            'description' => ['nullable', 'string', 'max:1200'],
            'cooking' => ['nullable', 'string', 'max:120'],
            'character' => ['nullable', 'string', 'max:120'],
            'price_per_kg' => ['required', 'numeric', 'min:0', 'max:99999'],
            'stock_kg' => ['required', 'numeric', 'min:0', 'max:99999'],
            'low_stock_threshold' => ['required', 'numeric', 'min:0', 'max:99999'],
            'min_quantity_kg' => ['required', 'numeric', 'min:0.1', 'max:999'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);
    }

    private function storeImage(Request $request): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }

        $path = $request->file('image')->store('shop-products', 'public');

        return 'storage/' . $path;
    }

    private function deleteStoredImage(?string $path): void
    {
        if (! $path || ! str_starts_with($path, 'storage/')) {
            return;
        }

        Storage::disk('public')->delete(substr($path, strlen('storage/')));
    }
}
