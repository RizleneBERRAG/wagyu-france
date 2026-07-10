<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureWagyuAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! Auth::check() || ! $user || ! $user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')->withErrors([
                'email' => 'Votre session a expiré ou votre compte n’est plus actif.',
            ]);
        }

        return $next($request);
    }
}
