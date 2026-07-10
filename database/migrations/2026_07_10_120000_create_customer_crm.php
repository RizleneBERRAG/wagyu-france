<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('individual');
            $table->string('relationship_status')->default('prospect');
            $table->string('company')->nullable();
            $table->string('fullname');
            $table->string('email');
            $table->string('email_key')->unique();
            $table->string('phone', 40)->nullable();
            $table->string('city', 120)->nullable();
            $table->string('professional_type', 120)->nullable();
            $table->string('preferred_contact', 30)->nullable();
            $table->json('tags')->nullable();
            $table->text('internal_notes')->nullable();
            $table->boolean('marketing_opt_in')->default(false);
            $table->timestamp('first_contact_at')->nullable();
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamp('last_contacted_at')->nullable();
            $table->timestamp('next_follow_up_at')->nullable();
            $table->timestamps();

            $table->index(['type', 'relationship_status']);
            $table->index('next_follow_up_at');
            $table->index('last_activity_at');
        });

        Schema::create('customer_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->string('type')->default('note');
            $table->string('title')->nullable();
            $table->text('body');
            $table->timestamp('happened_at')->nullable();
            $table->timestamp('due_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['customer_id', 'due_at']);
            $table->index(['due_at', 'completed_at']);
        });

        Schema::table('shop_order_requests', function (Blueprint $table) {
            $table->foreignId('customer_id')->nullable()->after('id')->constrained()->nullOnDelete();
        });

        Schema::table('pro_reservation_requests', function (Blueprint $table) {
            $table->foreignId('customer_id')->nullable()->after('id')->constrained()->nullOnDelete();
        });

        Schema::table('contact_messages', function (Blueprint $table) {
            $table->foreignId('customer_id')->nullable()->after('id')->constrained()->nullOnDelete();
        });

        $normalizeEmail = static fn (?string $email): string => mb_strtolower(trim((string) $email));

        $attachCustomer = function (string $sourceTable, object $source, array $profile) use ($normalizeEmail): void {
            $emailKey = $normalizeEmail($profile['email'] ?? null);

            if ($emailKey === '') {
                return;
            }

            $now = now();
            $existing = DB::table('customers')->where('email_key', $emailKey)->first();
            $sourceCreatedAt = $source->created_at ?? $now;
            $sourceUpdatedAt = $source->updated_at ?? $sourceCreatedAt;
            $incomingType = $profile['type'] ?? 'individual';
            $incomingStatus = $profile['relationship_status'] ?? 'prospect';

            if ($existing) {
                $typePriority = ['individual' => 1, 'partner' => 2, 'professional' => 3];
                $statusPriority = ['prospect' => 1, 'active' => 2, 'vip' => 3, 'dormant' => 1, 'blocked' => 4];
                $resolvedType = ($typePriority[$incomingType] ?? 1) > ($typePriority[$existing->type] ?? 1)
                    ? $incomingType
                    : $existing->type;
                $resolvedStatus = ($statusPriority[$incomingStatus] ?? 1) > ($statusPriority[$existing->relationship_status] ?? 1)
                    ? $incomingStatus
                    : $existing->relationship_status;

                DB::table('customers')->where('id', $existing->id)->update([
                    'type' => $resolvedType,
                    'relationship_status' => $resolvedStatus,
                    'company' => $profile['company'] ?: $existing->company,
                    'fullname' => $profile['fullname'] ?: $existing->fullname,
                    'email' => $profile['email'] ?: $existing->email,
                    'phone' => $profile['phone'] ?: $existing->phone,
                    'city' => $profile['city'] ?: $existing->city,
                    'professional_type' => $profile['professional_type'] ?: $existing->professional_type,
                    'preferred_contact' => $profile['preferred_contact'] ?: $existing->preferred_contact,
                    'first_contact_at' => min($existing->first_contact_at ?: $sourceCreatedAt, $sourceCreatedAt),
                    'last_activity_at' => max($existing->last_activity_at ?: $sourceUpdatedAt, $sourceUpdatedAt),
                    'updated_at' => $now,
                ]);

                $customerId = $existing->id;
            } else {
                $customerId = DB::table('customers')->insertGetId([
                    'type' => $incomingType,
                    'relationship_status' => $incomingStatus,
                    'company' => $profile['company'],
                    'fullname' => $profile['fullname'] ?: $profile['email'],
                    'email' => $profile['email'],
                    'email_key' => $emailKey,
                    'phone' => $profile['phone'],
                    'city' => $profile['city'],
                    'professional_type' => $profile['professional_type'],
                    'preferred_contact' => $profile['preferred_contact'],
                    'marketing_opt_in' => false,
                    'first_contact_at' => $sourceCreatedAt,
                    'last_activity_at' => $sourceUpdatedAt,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            DB::table($sourceTable)->where('id', $source->id)->update(['customer_id' => $customerId]);
        };

        DB::table('shop_order_requests')->orderBy('id')->get()->each(function ($order) use ($attachCustomer) {
            $active = in_array($order->status ?? null, ['confirmee', 'traitee'], true) || filled($order->invoice_number ?? null);
            $attachCustomer('shop_order_requests', $order, [
                'type' => 'individual',
                'relationship_status' => $active ? 'active' : 'prospect',
                'company' => null,
                'fullname' => $order->fullname,
                'email' => $order->email,
                'phone' => $order->phone,
                'city' => $order->city,
                'professional_type' => null,
                'preferred_contact' => null,
            ]);
        });

        DB::table('pro_reservation_requests')->orderBy('id')->get()->each(function ($request) use ($attachCustomer) {
            $active = in_array($request->status ?? null, ['confirmee', 'traitee'], true) || filled($request->invoice_number ?? null);
            $attachCustomer('pro_reservation_requests', $request, [
                'type' => 'professional',
                'relationship_status' => $active ? 'active' : 'prospect',
                'company' => $request->company,
                'fullname' => $request->fullname,
                'email' => $request->email,
                'phone' => $request->phone,
                'city' => $request->city,
                'professional_type' => $request->professional_type,
                'preferred_contact' => null,
            ]);
        });

        DB::table('contact_messages')->orderBy('id')->get()->each(function ($message) use ($attachCustomer) {
            $type = match ($message->audience ?? 'particulier') {
                'professionnel' => 'professional',
                'partenaire' => 'partner',
                default => 'individual',
            };

            $attachCustomer('contact_messages', $message, [
                'type' => $type,
                'relationship_status' => 'prospect',
                'company' => $message->company,
                'fullname' => $message->fullname,
                'email' => $message->email,
                'phone' => $message->phone,
                'city' => $message->city,
                'professional_type' => null,
                'preferred_contact' => $message->preferred_contact,
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropConstrainedForeignId('customer_id');
        });

        Schema::table('pro_reservation_requests', function (Blueprint $table) {
            $table->dropConstrainedForeignId('customer_id');
        });

        Schema::table('shop_order_requests', function (Blueprint $table) {
            $table->dropConstrainedForeignId('customer_id');
        });

        Schema::dropIfExists('customer_interactions');
        Schema::dropIfExists('customers');
    }
};
