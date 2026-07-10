<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const PERMISSIONS = [
        'dashboard.view' => 'Voir le tableau de bord',
        'products.manage' => 'Gérer les produits et les stocks',
        'animals.manage' => 'Gérer les animaux et la réserve',
        'orders.manage' => 'Traiter les commandes et demandes',
        'customers.manage' => 'Gérer le fichier clients et les relances',
        'billing.manage' => 'Émettre les factures et les avoirs',
        'logistics.manage' => 'Gérer la préparation et la livraison',
        'settings.manage' => 'Modifier les paramètres du site',
        'users.manage' => 'Gérer les utilisateurs administrateurs',
        'activity.view' => 'Consulter le journal d’activité',
    ];

    public const ROLES = [
        'owner' => 'Propriétaire',
        'manager' => 'Responsable',
        'sales' => 'Commercial',
        'operations' => 'Préparation & exploitation',
        'accounting' => 'Comptabilité',
        'viewer' => 'Lecture limitée',
    ];

    public const ROLE_PRESETS = [
        'owner' => [
            'dashboard.view',
            'products.manage',
            'animals.manage',
            'orders.manage',
            'customers.manage',
            'billing.manage',
            'logistics.manage',
            'settings.manage',
            'users.manage',
            'activity.view',
        ],
        'manager' => [
            'dashboard.view',
            'products.manage',
            'animals.manage',
            'orders.manage',
            'customers.manage',
            'billing.manage',
            'logistics.manage',
            'settings.manage',
            'activity.view',
        ],
        'sales' => [
            'dashboard.view',
            'orders.manage',
            'customers.manage',
            'billing.manage',
        ],
        'operations' => [
            'dashboard.view',
            'products.manage',
            'animals.manage',
            'orders.manage',
            'logistics.manage',
        ],
        'accounting' => [
            'dashboard.view',
            'orders.manage',
            'customers.manage',
            'billing.manage',
        ],
        'viewer' => [
            'dashboard.view',
        ],
    ];

    protected $fillable = [
        'name',
        'job_title',
        'email',
        'password',
        'role',
        'permissions',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'permissions' => 'array',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(AdminActivityLog::class);
    }

    public function canAccess(string $permission): bool
    {
        if (! $this->is_active) {
            return false;
        }

        if ($this->role === 'owner') {
            return true;
        }

        return in_array($permission, $this->effectivePermissions(), true);
    }

    public function effectivePermissions(): array
    {
        $permissions = $this->permissions;

        if (is_array($permissions) && $permissions !== []) {
            return array_values(array_intersect($permissions, array_keys(self::PERMISSIONS)));
        }

        return self::presetPermissions($this->role);
    }

    public static function presetPermissions(string $role): array
    {
        return self::ROLE_PRESETS[$role] ?? ['dashboard.view'];
    }

    public function getRoleLabelAttribute(): string
    {
        return self::ROLES[$this->role] ?? ucfirst($this->role);
    }
}
