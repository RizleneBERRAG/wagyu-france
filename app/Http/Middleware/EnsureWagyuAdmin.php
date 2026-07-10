<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureWagyuAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->get('wf_admin_authenticated') !== true) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
