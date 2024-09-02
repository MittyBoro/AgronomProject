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
        Schema::create('bonuses', function (Blueprint $table): void {
            $table->id();

            $table
                ->foreignId('user_id')
                ->index()
                ->constrained()
                ->cascadeOnDelete();

            $table
                ->foreignId('order_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->bigInteger('amount')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bonuses');
    }
};
