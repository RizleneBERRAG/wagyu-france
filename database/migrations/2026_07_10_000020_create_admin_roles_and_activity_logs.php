<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('job_title')->nullable()->after('name');
            $table->string('role')->default('manager')->after('email');
            $table->json('permissions')->nullable()->after('role');
            $table->boolean('is_active')->default(true)->after('permissions');
            $table->timestamp('last_login_at')->nullable()->after('remember_token');

            $table->index(['role', 'is_active']);
        });

        Schema::create('admin_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action', 120);
            $table->nullableMorphs('subject');
            $table->string('subject_label')->nullable();
            $table->text('description');
            $table->json('properties')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index(['action', 'created_at']);
            $table->index(['user_id', 'created_at']);
        });

        $email = mb_strtolower(trim((string) config('wagyu.admin_email')));
        $password = (string) config('wagyu.admin_password');
        $hasActiveOwner = DB::table('users')->where('role', 'owner')->where('is_active', true)->exists();

        if (! $hasActiveOwner && $email !== '' && $password !== '') {
            $existing = DB::table('users')->whereRaw('LOWER(email) = ?', [$email])->first();

            if ($existing) {
                DB::table('users')->where('id', $existing->id)->update([
                    'name' => $existing->name ?: (string) config('wagyu.admin_name', 'Propriétaire Wagyu France'),
                    'job_title' => $existing->job_title ?: 'Propriétaire',
                    'email' => $email,
                    'email_verified_at' => $existing->email_verified_at ?: now(),
                    'password' => Hash::make($password),
                    'role' => 'owner',
                    'permissions' => null,
                    'is_active' => true,
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('users')->insert([
                    'name' => (string) config('wagyu.admin_name', 'Propriétaire Wagyu France'),
                    'job_title' => 'Propriétaire',
                    'email' => $email,
                    'email_verified_at' => now(),
                    'password' => Hash::make($password),
                    'role' => 'owner',
                    'permissions' => null,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_activity_logs');

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role', 'is_active']);
            $table->dropColumn([
                'job_title',
                'role',
                'permissions',
                'is_active',
                'last_login_at',
            ]);
        });
    }
};
