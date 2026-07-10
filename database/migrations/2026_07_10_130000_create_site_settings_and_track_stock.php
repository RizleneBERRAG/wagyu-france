<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general');
            $table->string('type')->default('text');
            $table->timestamps();
        });

        Schema::table('shop_order_requests', function (Blueprint $table) {
            $table->timestamp('stock_applied_at')->nullable()->after('status');
        });

        $now = now();
        DB::table('site_settings')->insert([
            ['key' => 'brand_name', 'value' => 'Wagyu France', 'group' => 'general', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'contact_email', 'value' => 'contact@wagyufrance.fr', 'group' => 'general', 'type' => 'email', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'contact_phone', 'value' => null, 'group' => 'general', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'reply_delay', 'value' => 'Sous 2 jours ouvrés', 'group' => 'general', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'order_notification_email', 'value' => 'contact@wagyufrance.fr', 'group' => 'notifications', 'type' => 'email', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'pro_notification_email', 'value' => 'contact@wagyufrance.fr', 'group' => 'notifications', 'type' => 'email', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'contact_notification_email', 'value' => 'contact@wagyufrance.fr', 'group' => 'notifications', 'type' => 'email', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'delivery_area', 'value' => 'France métropolitaine, sous réserve de confirmation', 'group' => 'commerce', 'type' => 'textarea', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'withdrawal_address', 'value' => 'Ferme du Bois des Huttes, 02140 Landouzy-la-Ville, France', 'group' => 'commerce', 'type' => 'textarea', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'preparation_delay', 'value' => 'Confirmé individuellement selon la découpe et la disponibilité', 'group' => 'commerce', 'type' => 'textarea', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'legal_company_name', 'value' => null, 'group' => 'legal', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'legal_company_form', 'value' => null, 'group' => 'legal', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'legal_company_address', 'value' => 'Ferme du Bois des Huttes, 02140 Landouzy-la-Ville, France', 'group' => 'legal', 'type' => 'textarea', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'legal_company_siret', 'value' => null, 'group' => 'legal', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'legal_publication_director', 'value' => null, 'group' => 'legal', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'legal_host_name', 'value' => null, 'group' => 'legal', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'legal_host_address', 'value' => null, 'group' => 'legal', 'type' => 'textarea', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'legal_host_phone', 'value' => null, 'group' => 'legal', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'legal_mediator_name', 'value' => null, 'group' => 'legal', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'legal_mediator_address', 'value' => null, 'group' => 'legal', 'type' => 'textarea', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'legal_mediator_website', 'value' => null, 'group' => 'legal', 'type' => 'url', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::table('shop_order_requests', function (Blueprint $table) {
            $table->dropColumn('stock_applied_at');
        });

        Schema::dropIfExists('site_settings');
    }
};