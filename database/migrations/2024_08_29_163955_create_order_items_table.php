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
        Schema::create('order_items', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table
                ->foreignId('product_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table
                ->foreignId('product_variation_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table
                ->foreignId('media_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('proudct_title');
            $table->string('variation_title')->nullable();

            $table->unsignedInteger('quantity');
            $table->decimal('price', 8, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
