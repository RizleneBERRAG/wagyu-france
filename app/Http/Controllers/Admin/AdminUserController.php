<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::query()->withCount('activityLogs')->orderByDesc('is_active')->orderBy('name')->paginate(24),
            'roles' => User::ROLES,
            'counts' => [
                'total' => User::count(),
                'active' => User::where('is_active', true)->count(),
                'owners' => User::where('role', 'owner')->where('is_active', true)->count(),
                'inactive' => User::where('is_active', false)->count(),
            ],
        ]);
    }

    public function create(): View
    {
        return view('admin.users.form', $this->formData(new User([
            'role' => 'manager',
            'is_active' => true,
            'permissions' => User::presetPermissions('manager'),
        ])));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        $user = User::create([
            'name' => $data['name'],
            'job_title' => $data['job_title'] ?? null,
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $data['role'],
            'permissions' => $this->permissions($data['role'], $data['permissions'] ?? []),
            'is_active' => $request->boolean('is_active'),
        ]);

        $user->forceFill(['email_verified_at' => now()])->saveQuietly();

        return redirect()->route('admin.users.edit', $user)
            ->with('success', 'Le compte de ' . $user->name . ' a été créé.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.form', $this->formData($user));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $this->validatedData($request, $user);
        $isActive = $request->boolean('is_active');
        $newPermissions = $this->permissions($data['role'], $data['permissions'] ?? []);

        $this->guardOwnerContinuity($user, $data['role'], $isActive);
        $this->guardSelfAccessChanges($request, $user, $data['role'], $newPermissions, $isActive);

        $updates = [
            'name' => $data['name'],
            'job_title' => $data['job_title'] ?? null,
            'email' => $data['email'],
            'role' => $data['role'],
            'permissions' => $newPermissions,
            'is_active' => $isActive,
        ];

        if (filled($data['password'] ?? null)) {
            $updates['password'] = $data['password'];
        }

        $user->update($updates);

        return back()->with('success', 'Le compte de ' . $user->name . ' a été mis à jour.');
    }

    public function toggle(Request $request, User $user): RedirectResponse
    {
        $newState = ! $user->is_active;

        if ($request->user()->is($user) && ! $newState) {
            return back()->withErrors([
                'user' => 'Vous ne pouvez pas désactiver votre propre compte.',
            ]);
        }

        $this->guardOwnerContinuity($user, $user->role, $newState);
        $user->update(['is_active' => $newState]);

        return back()->with('success', $newState
            ? 'Le compte de ' . $user->name . ' est de nouveau actif.'
            : 'Le compte de ' . $user->name . ' a été désactivé.');
    }

    private function validatedData(Request $request, ?User $user = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:190'],
            'job_title' => ['nullable', 'string', 'max:190'],
            'email' => [
                'required',
                'email',
                'max:190',
                Rule::unique('users', 'email')->ignore($user?->getKey()),
            ],
            'role' => ['required', Rule::in(array_keys(User::ROLES))],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => [Rule::in(array_keys(User::PERMISSIONS))],
            'password' => [$user ? 'nullable' : 'required', 'string', 'min:12', 'confirmed'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'password.min' => 'Le mot de passe doit contenir au moins 12 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        $data['email'] = mb_strtolower(trim($data['email']));

        $duplicate = User::query()
            ->whereRaw('LOWER(email) = ?', [$data['email']])
            ->when($user, fn ($query) => $query->where('id', '!=', $user->getKey()))
            ->exists();

        if ($duplicate) {
            throw ValidationException::withMessages([
                'email' => 'Cette adresse email appartient déjà à un autre utilisateur.',
            ]);
        }

        return $data;
    }

    private function permissions(string $role, array $permissions): ?array
    {
        if ($role === 'owner') {
            return null;
        }

        return collect($permissions)
            ->push('dashboard.view')
            ->filter(fn ($permission) => array_key_exists($permission, User::PERMISSIONS))
            ->unique()
            ->values()
            ->all();
    }

    private function guardOwnerContinuity(User $user, string $newRole, bool $newState): void
    {
        if ($user->role !== 'owner' || ($newRole === 'owner' && $newState)) {
            return;
        }

        $otherActiveOwners = User::query()
            ->where('role', 'owner')
            ->where('is_active', true)
            ->where('id', '!=', $user->getKey())
            ->exists();

        if (! $otherActiveOwners) {
            throw ValidationException::withMessages([
                'role' => 'Le dernier propriétaire actif ne peut pas être désactivé ou rétrogradé.',
            ]);
        }
    }

    private function guardSelfAccessChanges(
        Request $request,
        User $user,
        string $newRole,
        ?array $newPermissions,
        bool $newState
    ): void {
        if (! $request->user()->is($user)) {
            return;
        }

        if (! $newState) {
            throw ValidationException::withMessages([
                'is_active' => 'Vous ne pouvez pas désactiver votre propre compte.',
            ]);
        }

        $currentPermissions = $user->effectivePermissions();
        $resolvedNewPermissions = $newRole === 'owner'
            ? User::presetPermissions('owner')
            : ($newPermissions ?? User::presetPermissions($newRole));

        sort($currentPermissions);
        sort($resolvedNewPermissions);

        if ($newRole !== $user->role || $currentPermissions !== $resolvedNewPermissions) {
            throw ValidationException::withMessages([
                'role' => 'Votre rôle et vos permissions doivent être modifiés par un autre propriétaire autorisé.',
            ]);
        }
    }

    private function formData(User $user): array
    {
        return [
            'adminUser' => $user,
            'roles' => User::ROLES,
            'permissions' => User::PERMISSIONS,
            'rolePresets' => User::ROLE_PRESETS,
        ];
    }
}
