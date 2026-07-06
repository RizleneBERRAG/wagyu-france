<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pro_reservation_requests', function (Blueprint $table) {
            $table->id();

            $table->string('reference')->unique();
            $table->string('bovin_reference')->default('WF-2026-01');

            $table->string('company');
            $table->string('fullname');
            $table->string('email');
            $table->string('phone');
            $table->string('professional_type');
            $table->string('city')->nullable();

            $table->text('message')->nullable();

            $table->json('cart');
            $table->decimal('total_ht', 10, 2)->default(0);

            $table->string('status')->default('nouvelle');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pro_reservation_requests');
    }
};
