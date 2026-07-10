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
            $table->decimal('final_total_ttc', 10, 2)->nullable()->after('total');
            $table->decimal('vat_rate', 5, 2)->nullable()->after('final_total_ttc');
            $table->string('payment_status')->default('pending')->after('status');
            $table->timestamp('paid_at')->nullable()->after('payment_status');
            $table->text('document_notes')->nullable()->after('paid_at');
            $table->string('invoice_number')->nullable()->unique()->after('document_notes');
            $table->timestamp('invoice_issued_at')->nullable()->after('invoice_number');
            $table->json('invoice_snapshot')->nullable()->after('invoice_issued_at');
        });

        Schema::table('pro_reservation_requests', function (Blueprint $table) {
            $table->decimal('final_total_ht', 10, 2)->nullable()->after('total_ht');
            $table->decimal('vat_rate', 5, 2)->nullable()->after('final_total_ht');
            $table->string('payment_status')->default('pending')->after('status');
            $table->timestamp('paid_at')->nullable()->after('payment_status');
            $table->text('document_notes')->nullable()->after('paid_at');
            $table->string('invoice_number')->nullable()->unique()->after('document_notes');
            $table->timestamp('invoice_issued_at')->nullable()->after('invoice_number');
            $table->json('invoice_snapshot')->nullable()->after('invoice_issued_at');
        });

        Schema::create('document_sequences', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->unsignedBigInteger('next_value')->default(1);
            $table->timestamps();
        });

        $now = now();
        $settings = [
            ['key' => 'invoice_prefix', 'value' => 'WF', 'group' => 'documents', 'type' => 'text'],
            ['key' => 'default_vat_rate', 'value' => null, 'group' => 'documents', 'type' => 'number'],
            ['key' => 'legal_vat_number', 'value' => null, 'group' => 'legal', 'type' => 'text'],
            ['key' => 'invoice_payment_terms', 'value' => 'Paiement selon les conditions convenues lors de la confirmation.', 'group' => 'documents', 'type' => 'textarea'],
            ['key' => 'invoice_bank_details', 'value' => null, 'group' => 'documents', 'type' => 'textarea'],
            ['key' => 'invoice_footer', 'value' => 'Merci pour votre confiance.', 'group' => 'documents', 'type' => 'textarea'],
        ];

        foreach ($settings as $setting) {
            DB::table('site_settings')->updateOrInsert(
                ['key' => $setting['key']],
                array_merge($setting, ['created_at' => $now, 'updated_at' => $now])
            );
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('document_sequences');

        Schema::table('shop_order_requests', function (Blueprint $table) {
            $table->dropColumn([
                'final_total_ttc',
                'vat_rate',
                'payment_status',
                'paid_at',
                'document_notes',
                'invoice_number',
                'invoice_issued_at',
                'invoice_snapshot',
            ]);
        });

        Schema::table('pro_reservation_requests', function (Blueprint $table) {
            $table->dropColumn([
                'final_total_ht',
                'vat_rate',
                'payment_status',
                'paid_at',
                'document_notes',
                'invoice_number',
                'invoice_issued_at',
                'invoice_snapshot',
            ]);
        });

        DB::table('site_settings')->whereIn('key', [
            'invoice_prefix',
            'default_vat_rate',
            'legal_vat_number',
            'invoice_payment_terms',
            'invoice_bank_details',
            'invoice_footer',
        ])->delete();
    }
};