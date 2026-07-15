<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shop_order_requests', function (Blueprint $table) {
            // These fields must not depend on columns created by a later migration.
            $table->timestamp('invoice_sent_at')->nullable();
            $table->string('preparation_status')->default('pending');
            $table->string('delivery_method')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->string('carrier')->nullable();
            $table->string('tracking_number')->nullable();
            $table->text('logistics_notes')->nullable();
            $table->timestamp('prepared_at')->nullable();
            $table->timestamp('dispatched_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
        });

        Schema::table('pro_reservation_requests', function (Blueprint $table) {
            // These fields must not depend on columns created by a later migration.
            $table->timestamp('invoice_sent_at')->nullable();
            $table->string('preparation_status')->default('pending');
            $table->string('delivery_method')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->string('carrier')->nullable();
            $table->string('tracking_number')->nullable();
            $table->text('logistics_notes')->nullable();
            $table->timestamp('prepared_at')->nullable();
            $table->timestamp('dispatched_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
        });

        Schema::create('credit_notes', function (Blueprint $table) {
            $table->id();
            $table->morphs('documentable');
            $table->string('number')->unique();
            $table->string('invoice_number');
            $table->text('reason');
            $table->decimal('amount_ht', 10, 2);
            $table->decimal('vat_rate', 5, 2);
            $table->decimal('vat_amount', 10, 2);
            $table->decimal('amount_ttc', 10, 2);
            $table->json('snapshot');
            $table->timestamp('issued_at');
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index('invoice_number');
        });

        $now = now();
        DB::table('site_settings')->updateOrInsert(
            ['key' => 'credit_prefix'],
            [
                'value' => 'AV-WF',
                'group' => 'documents',
                'type' => 'text',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_notes');

        Schema::table('shop_order_requests', function (Blueprint $table) {
            $table->dropColumn([
                'invoice_sent_at',
                'preparation_status',
                'delivery_method',
                'scheduled_at',
                'carrier',
                'tracking_number',
                'logistics_notes',
                'prepared_at',
                'dispatched_at',
                'delivered_at',
            ]);
        });

        Schema::table('pro_reservation_requests', function (Blueprint $table) {
            $table->dropColumn([
                'invoice_sent_at',
                'preparation_status',
                'delivery_method',
                'scheduled_at',
                'carrier',
                'tracking_number',
                'logistics_notes',
                'prepared_at',
                'dispatched_at',
                'delivered_at',
            ]);
        });

        DB::table('site_settings')->where('key', 'credit_prefix')->delete();
    }
};
