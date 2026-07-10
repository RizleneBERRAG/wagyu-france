<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AdminActivityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    public function login(): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()?->is_active) {
            return redirect()->route('admin.dashboard');
        }

        $accountReady = $this->accountStorageReady()
            && User::query()->where('is_active', true)->exists();

        return view('admin.login', compact('accountReady'));
    }

    public function authenticate(Request $request, AdminActivityService $activity): RedirectResponse
    {
        if (! $this->accountStorageReady()) {
            return back()->withErrors([
                'email' => 'La migration des comptes administrateurs doit être exécutée avant la première connexion.',
            ]);
        }

        $validated = $request->validate([
            'email' => ['required', 'email', 'max:190'],
            'password' => ['required', 'string'],
        ]);

        $email = mb_strtolower(trim($validated['email']));
        $key = 'wagyu-admin-login|' . $email . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withInput($request->only('email'))->withErrors([
                'email' => 'Trop de tentatives. Réessayez dans ' . RateLimiter::availableIn($key) . ' seconde(s).',
            ]);
        }

        $user = User::query()->whereRaw('LOWER(email) = ?', [$email])->first();

        if (! $user || ! $user->is_active || ! Hash::check($validated['password'], $user->password)) {
            RateLimiter::hit($key, 60);

            return back()
                ->withErrors(['email' => 'Identifiants incorrects ou compte désactivé.'])
                ->withInput($request->only('email'));
        }

        RateLimiter::clear($key);
        Auth::login($user);
        $request->session()->regenerate();

        $user->forceFill(['last_login_at' => now()])->saveQuietly();

        $activity->record(
            'auth.login',
            'Connexion à l’administration.',
            $user,
            ['role' => $user->role],
            $user,
            $request
        );

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request, AdminActivityService $activity): RedirectResponse
    {
        $user = $request->user();

        if ($user) {
            $activity->record(
                'auth.logout',
                'Déconnexion de l’administration.',
                $user,
                [],
                $user,
                $request
            );
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    private function accountStorageReady(): bool
    {
        return Schema::hasTable('users')
            && Schema::hasColumn('users', 'is_active')
            && Schema::hasTable('admin_activity_logs');
    }
}
