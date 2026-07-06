<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shop_order_requests', function (Blueprint $table) {
            $table->id();

            $table->string('reference')->unique();

            $table->string('fullname');
            $table->string('email');
            $table->string('phone');
            $table->string('city');

            $table->text('message')->nullable();

            $table->json('cart');
            $table->decimal('total', 10, 2)->default(0);

            $table->string('status')->default('nouvelle');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shop_order_requests');
    }
};
