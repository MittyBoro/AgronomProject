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
        Schema::create('banners', function (Blueprint $table): void {
            $table->id();

            $table->string('title', 512);
            $table->string('url', 1024)->nullable();

            $table->boolean('is_published')->default(0);

            $table->unsignedInteger('order_column')->default(0);

            $table->timestamp('published_until')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
