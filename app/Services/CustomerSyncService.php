<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CustomerSyncService
{
    public function sync(Model $source, array $profile): Customer
    {
        return DB::transaction(function () use ($source, $profile) {
            $email = trim((string) ($profile['email'] ?? ''));
            $emailKey = mb_strtolower($email);

            $customer = Customer::query()
                ->where('email_key', $emailKey)
                ->lockForUpdate()
                ->first();

            $type = $this->resolveType($customer?->type, (string) ($profile['type'] ?? 'individual'));
            $status = $this->resolveStatus($customer?->relationship_status, (string) ($profile['relationship_status'] ?? 'prospect'));
            $activityAt = $source->updated_at ?: now();

            $data = [
                'type' => $type,
                'relationship_status' => $status,
                'company' => $this->preferred($profile['company'] ?? null, $customer?->company),
                'fullname' => $this->preferred($profile['fullname'] ?? null, $customer?->fullname) ?: $email,
                'email' => $email,
                'email_key' => $emailKey,
                'phone' => $this->preferred($profile['phone'] ?? null, $customer?->phone),
                'city' => $this->preferred($profile['city'] ?? null, $customer?->city),
                'professional_type' => $this->preferred($profile['professional_type'] ?? null, $customer?->professional_type),
                'preferred_contact' => $this->preferred($profile['preferred_contact'] ?? null, $customer?->preferred_contact),
                'first_contact_at' => $customer?->first_contact_at ?: ($source->created_at ?: now()),
                'last_activity_at' => $activityAt,
            ];

            if ($customer) {
                $customer->update($data);
            } else {
                $customer = Customer::create($data);
            }

            $source->forceFill(['customer_id' => $customer->id])->save();

            return $customer;
        });
    }

    public function markActive(?Customer $customer): void
    {
        if (! $customer || $customer->relationship_status === 'blocked') {
            return;
        }

        $customer->update([
            'relationship_status' => $customer->relationship_status === 'vip' ? 'vip' : 'active',
            'last_activity_at' => now(),
        ]);
    }

    public function touch(?Customer $customer): void
    {
        $customer?->update(['last_activity_at' => now()]);
    }

    private function resolveType(?string $existing, string $incoming): string
    {
        $priority = ['individual' => 1, 'partner' => 2, 'professional' => 3];

        return ($priority[$incoming] ?? 1) > ($priority[$existing] ?? 0)
            ? $incoming
            : ($existing ?: $incoming);
    }

    private function resolveStatus(?string $existing, string $incoming): string
    {
        if ($existing === 'blocked' || $existing === 'vip') {
            return $existing;
        }

        if ($incoming === 'active') {
            return 'active';
        }

        return $existing ?: $incoming;
    }

    private function preferred(mixed $incoming, mixed $existing): mixed
    {
        return filled($incoming) ? trim((string) $incoming) : $existing;
    }
}
