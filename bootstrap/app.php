<?php

use App\Http\Middleware\EnsureAdminPermission;
use App\Http\Middleware\EnsureBillingForInvoiceDocument;
use App\Http\Middleware\EnsureWagyuAdmin;
use App\Http\Middleware\RecordAdminActivity;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'wagyu.admin' => EnsureWagyuAdmin::class,
            'wagyu.permission' => EnsureAdminPermission::class,
            'wagyu.invoice-document' => EnsureBillingForInvoiceDocument::class,
            'wagyu.audit' => RecordAdminActivity::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
