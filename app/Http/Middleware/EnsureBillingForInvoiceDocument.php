<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureBillingForInvoiceDocument
{
    public function handle(Request $request, Closure $next): Response
    {
        if ((string) $request->route('document') === 'invoice') {
            abort_unless(
                $request->user()?->canAccess('billing.manage'),
                403,
                'Le téléchargement d’une facture nécessite le droit de facturation.'
            );
        }

        return $next($request);
    }
}
