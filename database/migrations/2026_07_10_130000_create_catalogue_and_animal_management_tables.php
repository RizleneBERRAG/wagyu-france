<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shop_products', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('reference')->nullable();
            $table->string('badge')->nullable();
            $table->string('category_label')->nullable();
            $table->json('categories')->nullable();
            $table->text('description')->nullable();
            $table->string('cooking')->nullable();
            $table->string('character')->nullable();
            $table->decimal('price_per_kg', 10, 2);
            $table->decimal('stock_kg', 10, 2)->default(0);
            $table->decimal('low_stock_threshold', 10, 2)->default(2);
            $table->decimal('min_quantity_kg', 8, 2)->default(1);
            $table->string('image_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('animal_batches', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('name');
            $table->string('status')->default('draft');
            $table->unsignedTinyInteger('launch_threshold_percent')->default(50);
            $table->boolean('is_active')->default(false);
            $table->timestamp('opens_at')->nullable();
            $table->timestamp('cutting_planned_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('animal_cuts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_batch_id')->constrained()->cascadeOnDelete();
            $table->string('slug');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price_per_kg', 10, 2);
            $table->decimal('available_kg', 10, 2)->default(0);
            $table->decimal('min_quantity_kg', 8, 2)->default(1);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['animal_batch_id', 'slug']);
        });

        $now = now();

        DB::table('shop_products')->insert([
            [
                'slug' => 'entrecote',
                'name' => 'Entrecôte Wagyu',
                'reference' => 'Pièce 01 · Collection signature',
                'badge' => 'La signature',
                'category_label' => 'Pièce noble · À saisir',
                'categories' => json_encode(['noble', 'grill']),
                'description' => 'Généreuse et intensément persillée, avec une texture fondante et un goût profond.',
                'cooking' => 'Saisie vive',
                'character' => 'Intense',
                'price_per_kg' => 174,
                'stock_kg' => 8.5,
                'low_stock_threshold' => 2,
                'min_quantity_kg' => 1,
                'image_path' => 'assets/images/boutique/entrecote-wagyu.jpg',
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'slug' => 'filet',
                'name' => 'Filet Wagyu',
                'reference' => 'Pièce 02 · Collection délicate',
                'badge' => 'Très tendre',
                'category_label' => 'Pièce premium · Délicate',
                'categories' => json_encode(['noble', 'grill']),
                'description' => 'Une pièce fine et particulièrement fondante, idéale pour une cuisson courte et précise.',
                'cooking' => 'Courte',
                'character' => 'Délicat',
                'price_per_kg' => 198,
                'stock_kg' => 4.2,
                'low_stock_threshold' => 1.5,
                'min_quantity_kg' => 1,
                'image_path' => 'assets/images/boutique/filet-wagyu.jpg',
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 20,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'slug' => 'fauxfilet',
                'name' => 'Faux-filet Wagyu',
                'reference' => 'Pièce 03 · Collection équilibre',
                'badge' => 'Équilibré',
                'category_label' => 'Persillé · À partager',
                'categories' => json_encode(['noble', 'grill']),
                'description' => 'Un bel équilibre entre tendreté, persillage et tenue à la cuisson.',
                'cooking' => 'Poêle ou grill',
                'character' => 'Équilibré',
                'price_per_kg' => 174,
                'stock_kg' => 7.1,
                'low_stock_threshold' => 2,
                'min_quantity_kg' => 1,
                'image_path' => 'assets/images/boutique/faux-filet-wagyu.jpg',
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 30,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'slug' => 'rumsteak',
                'name' => 'Rumsteak Wagyu',
                'reference' => 'Pièce 04 · Collection caractère',
                'badge' => 'De caractère',
                'category_label' => 'Goût franc · Belle mâche',
                'categories' => json_encode(['caractere', 'grill']),
                'description' => 'Une pièce expressive et régulière, à servir simplement pour préserver son caractère.',
                'cooking' => 'Saisie',
                'character' => 'Franc',
                'price_per_kg' => 137,
                'stock_kg' => 6.4,
                'low_stock_threshold' => 2,
                'min_quantity_kg' => 1,
                'image_path' => 'assets/images/boutique/rumsteak-wagyu.jpg',
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 40,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'slug' => 'paleron',
                'name' => 'Paleron Wagyu',
                'reference' => 'Pièce 05 · Collection bistronomie',
                'badge' => 'À mijoter',
                'category_label' => 'Cuisson lente · Savoureux',
                'categories' => json_encode(['lent', 'caractere']),
                'description' => 'Riche et généreux, il devient particulièrement fondant après une cuisson douce et longue.',
                'cooking' => 'Lente',
                'character' => 'Profond',
                'price_per_kg' => 143,
                'stock_kg' => 5.8,
                'low_stock_threshold' => 2,
                'min_quantity_kg' => 1,
                'image_path' => 'assets/images/boutique/paleron-wagyu.jpg',
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 50,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'slug' => 'jarret',
                'name' => 'Jarret Wagyu',
                'reference' => 'Pièce 06 · Collection tradition',
                'badge' => 'Tradition',
                'category_label' => 'Préparation longue · Jus',
                'categories' => json_encode(['lent', 'caractere']),
                'description' => 'Idéal pour les bouillons, les jus et les plats mijotés aux saveurs profondes.',
                'cooking' => 'Très lente',
                'character' => 'Généreux',
                'price_per_kg' => 92,
                'stock_kg' => 4.9,
                'low_stock_threshold' => 2,
                'min_quantity_kg' => 1,
                'image_path' => 'assets/images/boutique/jarret-wagyu.jpg',
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 60,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        $animalId = DB::table('animal_batches')->insertGetId([
            'reference' => 'WF-2026-01',
            'name' => 'Réserve Wagyu France · 2026-01',
            'status' => 'open',
            'launch_threshold_percent' => 50,
            'is_active' => true,
            'opens_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('animal_cuts')->insert([
            ['animal_batch_id' => $animalId, 'slug' => 'paleron', 'name' => 'Paleron Wagyu', 'description' => 'Pièce de l’épaule, riche et savoureuse, idéale pour cuisson lente, effiloché premium ou carte bistronomique.', 'price_per_kg' => 143, 'available_kg' => 5.8, 'min_quantity_kg' => 2, 'is_active' => true, 'sort_order' => 10, 'created_at' => $now, 'updated_at' => $now],
            ['animal_batch_id' => $animalId, 'slug' => 'entrecote', 'name' => 'Entrecôte Wagyu', 'description' => 'Pièce emblématique située sur la partie haute du dos, persillage intense, parfaite pour les restaurants premium.', 'price_per_kg' => 174, 'available_kg' => 8.5, 'min_quantity_kg' => 2, 'is_active' => true, 'sort_order' => 20, 'created_at' => $now, 'updated_at' => $now],
            ['animal_batch_id' => $animalId, 'slug' => 'fauxfilet', 'name' => 'Faux-filet Wagyu', 'description' => 'Zone dorsale arrière, équilibre idéal entre tendreté, puissance aromatique et rendement professionnel.', 'price_per_kg' => 174, 'available_kg' => 7.1, 'min_quantity_kg' => 2, 'is_active' => true, 'sort_order' => 30, 'created_at' => $now, 'updated_at' => $now],
            ['animal_batch_id' => $animalId, 'slug' => 'rumsteak', 'name' => 'Rumsteak Wagyu', 'description' => 'Pièce arrière de caractère, régulière et élégante, adaptée aux menus dégustation et découpes précises.', 'price_per_kg' => 137, 'available_kg' => 6.4, 'min_quantity_kg' => 2, 'is_active' => true, 'sort_order' => 40, 'created_at' => $now, 'updated_at' => $now],
            ['animal_batch_id' => $animalId, 'slug' => 'filet', 'name' => 'Filet Wagyu', 'description' => 'Pièce noble et fondante, située sous la zone lombaire, idéale pour une carte gastronomique.', 'price_per_kg' => 198, 'available_kg' => 4.2, 'min_quantity_kg' => 1, 'is_active' => true, 'sort_order' => 50, 'created_at' => $now, 'updated_at' => $now],
            ['animal_batch_id' => $animalId, 'slug' => 'macreuse', 'name' => 'Macreuse Wagyu', 'description' => 'Morceau de l’avant, intéressant pour les chefs qui souhaitent valoriser des pièces moins classiques.', 'price_per_kg' => 119, 'available_kg' => 5.2, 'min_quantity_kg' => 2, 'is_active' => true, 'sort_order' => 60, 'created_at' => $now, 'updated_at' => $now],
            ['animal_batch_id' => $animalId, 'slug' => 'jarret', 'name' => 'Jarret Wagyu', 'description' => 'Pièce basse de la patte, parfaite pour jus, bouillons, plats mijotés et préparations gastronomiques longues.', 'price_per_kg' => 92, 'available_kg' => 4.9, 'min_quantity_kg' => 2, 'is_active' => true, 'sort_order' => 70, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('animal_cuts');
        Schema::dropIfExists('animal_batches');
        Schema::dropIfExists('shop_products');
    }
};
