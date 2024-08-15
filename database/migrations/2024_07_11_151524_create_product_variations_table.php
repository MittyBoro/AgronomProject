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
        Schema::create('product_variations', function (Blueprint $table): void {
            $table->id();
            $table
                ->foreignId('product_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table
                ->foreignId('variation_group_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title')->nullable(); // e.g., 100ml, 200ml, 1kg
            $table->decimal('price_modifier', 8, 2)->default(0);
            $table->integer('stock')->default(0);

            $table->integer('order_column')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variations');
    }
};
