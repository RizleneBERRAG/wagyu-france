<?php

use App\Http\Controllers\Admin\AdminActivityController;
use App\Http\Controllers\Admin\AdminAnimalController;
use App\Http\Controllers\Admin\AdminAnimalCutController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminBillingController;
use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\Admin\AdminCustomerCreateController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminLogisticsController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\CommercialDocumentController;
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

Route::middleware(['wagyu.admin', 'wagyu.audit'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware('wagyu.permission:dashboard.view')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    });

    Route::middleware('wagyu.permission:products.manage')->group(function () {
        Route::get('/produits', [AdminProductController::class, 'index'])->name('products.index');
        Route::get('/produits/nouveau', [AdminProductController::class, 'create'])->name('products.create');
        Route::post('/produits', [AdminProductController::class, 'store'])->name('products.store');
        Route::get('/produits/{product}/modifier', [AdminProductController::class, 'edit'])->name('products.edit');
        Route::put('/produits/{product}', [AdminProductController::class, 'update'])->name('products.update');
        Route::patch('/produits/{product}/visibilite', [AdminProductController::class, 'toggle'])->name('products.toggle');
        Route::delete('/produits/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
    });

    Route::middleware('wagyu.permission:animals.manage')->group(function () {
        Route::get('/animaux', [AdminAnimalController::class, 'index'])->name('animals.index');
        Route::get('/animaux/nouveau', [AdminAnimalController::class, 'create'])->name('animals.create');
        Route::post('/animaux', [AdminAnimalController::class, 'store'])->name('animals.store');
        Route::get('/animaux/{animal}', [AdminAnimalController::class, 'show'])->name('animals.show');
        Route::get('/animaux/{animal}/modifier', [AdminAnimalController::class, 'edit'])->name('animals.edit');
        Route::put('/animaux/{animal}', [AdminAnimalController::class, 'update'])->name('animals.update');
        Route::patch('/animaux/{animal}/publier', [AdminAnimalController::class, 'activate'])->name('animals.activate');
        Route::delete('/animaux/{animal}', [AdminAnimalController::class, 'destroy'])->name('animals.destroy');
        Route::put('/animaux/{animal}/pieces/{cut}', [AdminAnimalCutController::class, 'update'])->name('animals.cuts.update');
    });

    Route::middleware('wagyu.permission:orders.manage')->group(function () {
        Route::get('/demandes', [DemandesController::class, 'index'])->name('demandes');
        Route::get('/demandes/export/{section}', [DemandesController::class, 'export'])->name('demandes.export');
        Route::patch('/demandes/boutique/{shopOrderRequest}/statut', [DemandesController::class, 'updateShopStatus'])
            ->name('demandes.shop.status');
        Route::patch('/demandes/pro/{proReservationRequest}/statut', [DemandesController::class, 'updateProStatus'])
            ->name('demandes.pro.status');
        Route::patch('/demandes/contact/{contactMessage}/statut', [DemandesController::class, 'updateContactStatus'])
            ->name('demandes.contact.status');

        Route::get('/demandes/boutique/{shopOrderRequest}', [CommercialDocumentController::class, 'showShop'])
            ->name('documents.shop.show');
        Route::put('/demandes/boutique/{shopOrderRequest}/commercial', [CommercialDocumentController::class, 'updateShop'])
            ->name('documents.shop.update');
        Route::post('/demandes/boutique/{shopOrderRequest}/facture', [CommercialDocumentController::class, 'issueShopInvoice'])
            ->name('documents.shop.invoice.issue');
        Route::get('/demandes/boutique/{shopOrderRequest}/documents/{document}', [CommercialDocumentController::class, 'shopPdf'])
            ->name('documents.shop.pdf');

        Route::get('/demandes/pro/{proReservationRequest}', [CommercialDocumentController::class, 'showPro'])
            ->name('documents.pro.show');
        Route::put('/demandes/pro/{proReservationRequest}/commercial', [CommercialDocumentController::class, 'updatePro'])
            ->name('documents.pro.update');
        Route::post('/demandes/pro/{proReservationRequest}/facture', [CommercialDocumentController::class, 'issueProInvoice'])
            ->name('documents.pro.invoice.issue');
        Route::get('/demandes/pro/{proReservationRequest}/documents/{document}', [CommercialDocumentController::class, 'proPdf'])
            ->name('documents.pro.pdf');
    });

    Route::middleware('wagyu.permission:customers.manage')->group(function () {
        Route::get('/clients/nouveau', [AdminCustomerCreateController::class, 'create'])->name('customers.create');
        Route::post('/clients', [AdminCustomerCreateController::class, 'store'])->name('customers.store');
        Route::get('/clients/export', [AdminCustomerController::class, 'export'])->name('customers.export');
        Route::get('/clients', [AdminCustomerController::class, 'index'])->name('customers.index');
        Route::get('/clients/{customer}', [AdminCustomerController::class, 'show'])->name('customers.show');
        Route::put('/clients/{customer}', [AdminCustomerController::class, 'update'])->name('customers.update');
        Route::post('/clients/{customer}/interactions', [AdminCustomerController::class, 'addInteraction'])
            ->name('customers.interactions.store');
        Route::patch('/clients/{customer}/interactions/{interaction}/terminer', [AdminCustomerController::class, 'completeInteraction'])
            ->name('customers.interactions.complete');
    });

    Route::middleware('wagyu.permission:billing.manage')->group(function () {
        Route::get('/facturation', [AdminBillingController::class, 'index'])->name('billing.index');
        Route::post('/facturation/boutique/{shopOrderRequest}/envoyer-facture', [AdminBillingController::class, 'sendShopInvoice'])
            ->name('billing.shop.invoice.send');
        Route::post('/facturation/pro/{proReservationRequest}/envoyer-facture', [AdminBillingController::class, 'sendProInvoice'])
            ->name('billing.pro.invoice.send');
        Route::post('/facturation/boutique/{shopOrderRequest}/avoir', [AdminBillingController::class, 'issueShopCredit'])
            ->name('billing.shop.credit.issue');
        Route::post('/facturation/pro/{proReservationRequest}/avoir', [AdminBillingController::class, 'issueProCredit'])
            ->name('billing.pro.credit.issue');
        Route::get('/facturation/avoirs/{creditNote}/pdf', [AdminBillingController::class, 'creditPdf'])
            ->name('billing.credit.pdf');
        Route::post('/facturation/avoirs/{creditNote}/envoyer', [AdminBillingController::class, 'sendCredit'])
            ->name('billing.credit.send');
    });

    Route::middleware('wagyu.permission:logistics.manage')->group(function () {
        Route::get('/logistique', [AdminLogisticsController::class, 'index'])->name('logistics.index');
        Route::put('/logistique/boutique/{shopOrderRequest}', [AdminLogisticsController::class, 'updateShop'])
            ->name('logistics.shop.update');
        Route::put('/logistique/pro/{proReservationRequest}', [AdminLogisticsController::class, 'updatePro'])
            ->name('logistics.pro.update');
    });

    Route::middleware('wagyu.permission:settings.manage')->group(function () {
        Route::get('/parametres', [AdminSettingsController::class, 'index'])->name('settings.index');
        Route::put('/parametres', [AdminSettingsController::class, 'update'])->name('settings.update');
    });

    Route::middleware('wagyu.permission:users.manage')->group(function () {
        Route::get('/utilisateurs', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/utilisateurs/nouveau', [AdminUserController::class, 'create'])->name('users.create');
        Route::post('/utilisateurs', [AdminUserController::class, 'store'])->name('users.store');
        Route::get('/utilisateurs/{user}/modifier', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/utilisateurs/{user}', [AdminUserController::class, 'update'])->name('users.update');
        Route::patch('/utilisateurs/{user}/activation', [AdminUserController::class, 'toggle'])->name('users.toggle');
    });

    Route::middleware('wagyu.permission:activity.view')->group(function () {
        Route::get('/journal-activite', [AdminActivityController::class, 'index'])->name('activity.index');
    });
});
