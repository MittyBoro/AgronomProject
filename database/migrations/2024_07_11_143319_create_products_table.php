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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->index()->unique();
            $table->string('name');
            $table->text('description')->nullable();

            $table->decimal('price', 12, 2);
            $table->integer('stock')->default(0);
            $table->boolean('is_published')->default(false);

            $table->string('meta_title', 255)->nullable();
            $table->string('meta_description', 1024)->nullable();
            $table->string('meta_keywords', 512)->nullable();

            $table->unsignedInteger('position')->default(0);

            $table->timestamps();
        });

        // ставим первый id = 1000, для красивых чисел
        DB::statement('ALTER TABLE `products` AUTO_INCREMENT = 1000;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
