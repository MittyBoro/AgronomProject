<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('cart_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('price', 8, 2);
            $table->timestamps();
        });

        Schema::create('cart_item_product_variation', function (
            Blueprint $table,
        ): void {
            $table->foreignId('cart_item_id')->constrained()->cascadeOnDelete();
            $table
                ->foreignId('product_variation_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->unique(
                ['cart_item_id', 'product_variation_id'],
                'ci_id_pv_id_unique',
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_item_product_variation');
        Schema::dropIfExists('cart_items');
    }
};
