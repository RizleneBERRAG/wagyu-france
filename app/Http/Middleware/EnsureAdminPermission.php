<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        abort_unless($user && $user->canAccess($permission), 403, 'Vous ne disposez pas des droits nécessaires pour accéder à cette section.');

        return $next($request);
    }
}
