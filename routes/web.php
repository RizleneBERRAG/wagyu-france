<?php

use App\Http\Controllers\Admin\AdminAnimalController;
use App\Http\Controllers\Admin\AdminAnimalCutController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\DemandesController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\ProReservationRequestController;
use App\Http\Controllers\ReserveProController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ShopOrderRequestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Pages principales
|--------------------------------------------------------------------------
*/

Route::view('/', 'pages.home')->name('home');
Route::get('/boutique', [ShopController::class, 'index'])->name('boutique');
Route::view('/le-wagyu', 'pages.wagyu')->name('wagyu');
Route::view('/histoire', 'pages.histoire')->name('histoire');
Route::view('/blog', 'pages.blog')->name('blog');

Route::view('/contact', 'pages.contact')->name('contact');
Route::post('/contact', [ContactMessageController::class, 'store'])->name('contact.store');

Route::view('/mentions-legales', 'pages.mentions-legales')->name('mentions.legales');
Route::view('/politique-de-confidentialite', 'pages.confidentialite')->name('confidentialite');
Route::view('/conditions-generales-de-vente', 'pages.cgv')->name('cgv');

/*
|--------------------------------------------------------------------------
| Univers professionnel
|--------------------------------------------------------------------------
*/

Route::view('/professionnels', 'pages.professionnels')->name('professionnels');
Route::get('/reserve-professionnelle', [ReserveProController::class, 'index'])->name('reserve.pro');
Route::view('/decoupe-volumes', 'pages.decoupe-volumes')->name('decoupe-volumes');
Route::view('/tracabilite', 'pages.tracabilite')->name('tracabilite');

/*
|--------------------------------------------------------------------------
| Demandes clients et professionnelles
|--------------------------------------------------------------------------
*/

Route::post('/reserve-pro/demande', [ProReservationRequestController::class, 'store'])
    ->name('reserve-pro.request.store');

Route::post('/boutique/demande', [ShopOrderRequestController::class, 'store'])
    ->name('shop.order.store');

/*
|--------------------------------------------------------------------------
| Administration client
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'authenticate'])->name('admin.authenticate');

Route::middleware('wagyu.admin')->prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/produits', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/produits/nouveau', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/produits', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/produits/{product}/modifier', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/produits/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::patch('/produits/{product}/visibilite', [AdminProductController::class, 'toggle'])->name('products.toggle');
    Route::delete('/produits/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/animaux', [AdminAnimalController::class, 'index'])->name('animals.index');
    Route::get('/animaux/nouveau', [AdminAnimalController::class, 'create'])->name('animals.create');
    Route::post('/animaux', [AdminAnimalController::class, 'store'])->name('animals.store');
    Route::get('/animaux/{animal}', [AdminAnimalController::class, 'show'])->name('animals.show');
    Route::get('/animaux/{animal}/modifier', [AdminAnimalController::class, 'edit'])->name('animals.edit');
    Route::put('/animaux/{animal}', [AdminAnimalController::class, 'update'])->name('animals.update');
    Route::patch('/animaux/{animal}/publier', [AdminAnimalController::class, 'activate'])->name('animals.activate');
    Route::delete('/animaux/{animal}', [AdminAnimalController::class, 'destroy'])->name('animals.destroy');
    Route::put('/animaux/{animal}/pieces/{cut}', [AdminAnimalCutController::class, 'update'])->name('animals.cuts.update');

    Route::get('/demandes', [DemandesController::class, 'index'])->name('demandes');
    Route::patch('/demandes/boutique/{shopOrderRequest}/statut', [DemandesController::class, 'updateShopStatus'])
        ->name('demandes.shop.status');
    Route::patch('/demandes/pro/{proReservationRequest}/statut', [DemandesController::class, 'updateProStatus'])
        ->name('demandes.pro.status');
    Route::patch('/demandes/contact/{contactMessage}/statut', [DemandesController::class, 'updateContactStatus'])
        ->name('demandes.contact.status');
});
