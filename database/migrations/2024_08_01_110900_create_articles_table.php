<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Таблица статей
        Schema::create('articles', function (Blueprint $table): void {
            $table->id();

            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('content');

            $table->boolean('is_published')->default(false);

            $table->string('meta_title', 255)->nullable();
            $table->string('meta_description', 1024)->nullable();
            $table->string('meta_keywords', 512)->nullable();

            $table->integer('order_column')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
