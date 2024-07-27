<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table): void {
            $table->id();

            $table->string('slug')->index()->unique();

            $table->json('title');
            $table->json('description');
            $table->json('meta_title');
            $table->json('meta_description');
            $table->json('meta_keywords');

            $table->json('fields')->default(new Expression('(JSON_ARRAY())'));

            $table->string('view')->nullable();

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
