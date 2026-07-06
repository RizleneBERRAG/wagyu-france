<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

        $expectedPassword = (string) config('wagyu.admin_password');

        if (! hash_equals($expectedPassword, $validated['password'])) {
            return back()
                ->withErrors(['password' => 'Mot de passe incorrect.'])
                ->withInput();
        }

        session([
            'wf_admin_authenticated' => true,
        ]);

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('wf_admin_authenticated');

        return redirect()->route('admin.login');
    }
}
