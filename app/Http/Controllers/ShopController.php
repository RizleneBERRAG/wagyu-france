<?php

namespace App\Http\Controllers;

use App\Models\ShopProduct;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function index(): View
    {
        return view('pages.boutique', [
            'products' => ShopProduct::visible()->get(),
        ]);
    }
}
