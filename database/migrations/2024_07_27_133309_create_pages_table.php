<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table): void {
            $table->id();

            $table->string('slug')->index()->unique();

            $table->string('title');
            $table->text('content')->nullable();

            $table->string('meta_title', 255)->nullable();
            $table->string('meta_description', 1024)->nullable();
            $table->string('meta_keywords', 512)->nullable();

            $table->json('blocks')->default(new Expression('(JSON_ARRAY())'));

            $table->string('layout')->nullable();

            $table->unsignedInteger('order_column')->default(0);

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
