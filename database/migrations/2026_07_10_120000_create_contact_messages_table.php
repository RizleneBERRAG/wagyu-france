<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('audience', 40);
            $table->string('fullname', 190);
            $table->string('email', 190);
            $table->string('phone', 40)->nullable();
            $table->string('company', 190)->nullable();
            $table->string('city', 120)->nullable();
            $table->string('subject', 190);
            $table->text('message');
            $table->string('preferred_contact', 30)->default('email');
            $table->string('status', 40)->default('nouvelle');
            $table->timestamp('privacy_accepted_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index('audience');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};
