<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table): void {
            $table->id();

            $table
                ->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete()
                ->nullable();

            $table->foreignId('user_id')->constrained()->nullable();

            $table->boolean('is_approved')->default(false);
            $table->boolean('is_pinned')->default(false);

            $table->unsignedTinyInteger('rating');
            $table->string('name')->nullable();
            $table->text('comment')->nullable();

            $table->bigInteger('likes')->default(0);

            $table->timestamps();
        });

        DB::statement('ALTER TABLE `reviews` AUTO_INCREMENT = 1000;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
