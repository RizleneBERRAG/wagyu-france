<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'type',
        'relationship_status',
        'company',
        'fullname',
        'email',
        'email_key',
        'phone',
        'city',
        'professional_type',
        'preferred_contact',
        'tags',
        'internal_notes',
        'marketing_opt_in',
        'first_contact_at',
        'last_activity_at',
        'last_contacted_at',
        'next_follow_up_at',
    ];

    protected $casts = [
        'tags' => 'array',
        'marketing_opt_in' => 'boolean',
        'first_contact_at' => 'datetime',
        'last_activity_at' => 'datetime',
        'last_contacted_at' => 'datetime',
        'next_follow_up_at' => 'datetime',
    ];

    public function shopOrders(): HasMany
    {
        return $this->hasMany(ShopOrderRequest::class);
    }

    public function proReservations(): HasMany
    {
        return $this->hasMany(ProReservationRequest::class);
    }

    public function contactMessages(): HasMany
    {
        return $this->hasMany(ContactMessage::class);
    }

    public function interactions(): HasMany
    {
        return $this->hasMany(CustomerInteraction::class)->latest('happened_at')->latest('id');
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->company ?: $this->fullname;
    }

    public function getTypeLabelAttribute(): string
    {
        return [
            'individual' => 'Particulier',
            'professional' => 'Professionnel',
            'partner' => 'Partenaire',
        ][$this->type] ?? ucfirst($this->type);
    }

    public function getRelationshipLabelAttribute(): string
    {
        return [
            'prospect' => 'Prospect',
            'active' => 'Client actif',
            'vip' => 'Client VIP',
            'dormant' => 'À réactiver',
            'blocked' => 'Bloqué',
        ][$this->relationship_status] ?? ucfirst($this->relationship_status);
    }
}
