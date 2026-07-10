<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    public function login(): View|RedirectResponse
    {
        if (session('wf_admin_authenticated') === true) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'password' => ['required', 'string'],
        ]);

        $key = 'wagyu-admin-login|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors([
                'password' => 'Trop de tentatives. Réessayez dans ' . RateLimiter::availableIn($key) . ' seconde(s).',
            ]);
        }

        $expectedPassword = (string) config('wagyu.admin_password');

        if ($expectedPassword === '' || ! hash_equals($expectedPassword, $validated['password'])) {
            RateLimiter::hit($key, 60);

            return back()
                ->withErrors(['password' => 'Mot de passe incorrect.'])
                ->withInput();
        }

        RateLimiter::clear($key);
        $request->session()->regenerate();
        $request->session()->put('wf_admin_authenticated', true);

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
