<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProReservationRequestController;
use App\Http\Controllers\ShopOrderRequestController;
use App\Http\Controllers\Admin\DemandesController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;

/*
|--------------------------------------------------------------------------
| Pages principales
|--------------------------------------------------------------------------
*/

Route::view('/', 'pages.home')->name('home');

Route::view('/boutique', 'pages.boutique')->name('boutique');

Route::view('/le-wagyu', 'pages.wagyu')->name('wagyu');

Route::view('/histoire', 'pages.histoire')->name('histoire');

Route::view('/blog', 'pages.blog')->name('blog');

Route::view('/contact', 'pages.contact')->name('contact');

Route::view('/mentions-legales', 'pages.mentions-legales')->name('mentions.legales');

Route::view('/politique-de-confidentialite', 'pages.confidentialite')->name('confidentialite');

Route::view('/conditions-generales-de-vente', 'pages.cgv')->name('cgv');

/*
|--------------------------------------------------------------------------
| Univers professionnel
|--------------------------------------------------------------------------
*/

Route::view('/professionnels', 'pages.professionnels')->name('professionnels');

Route::view('/reserve-professionnelle', 'pages.reserve-pro')->name('reserve.pro');

Route::view('/decoupe-volumes', 'pages.decoupe-volumes')->name('decoupe-volumes');

Route::view('/tracabilite', 'pages.tracabilite')->name('tracabilite');

/*
|--------------------------------------------------------------------------
| Demandes de pré-réservation pro
|--------------------------------------------------------------------------
*/

Route::post('/reserve-pro/demande', [ProReservationRequestController::class, 'store'])
    ->name('reserve-pro.request.store');

Route::post('/boutique/demande', [ShopOrderRequestController::class, 'store'])
    ->name('shop.order.store');


/*
|--------------------------------------------------------------------------
| Administration interne
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Administration interne
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AdminAuthController::class, 'login'])
    ->name('admin.login');

Route::post('/admin/login', [AdminAuthController::class, 'authenticate'])
    ->name('admin.authenticate');

Route::post('/admin/logout', [AdminAuthController::class, 'logout'])
    ->name('admin.logout');

Route::get('/admin', [AdminDashboardController::class, 'index'])
    ->name('admin.dashboard');

Route::get('/admin/demandes', [DemandesController::class, 'index'])
    ->name('admin.demandes');

Route::patch('/admin/demandes/boutique/{shopOrderRequest}/statut', [DemandesController::class, 'updateShopStatus'])
    ->name('admin.demandes.shop.status');

Route::patch('/admin/demandes/pro/{proReservationRequest}/statut', [DemandesController::class, 'updateProStatus'])
    ->name('admin.demandes.pro.status');

