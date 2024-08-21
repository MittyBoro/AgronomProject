<?php

use App\Enums\CartTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table): void {
            $table->id();

            $table
                ->enum('type', CartTypeEnum::values())
                ->default(CartTypeEnum::Cart->value);

            $table
                ->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
            $table->string('session_id')->nullable();
            $table->timestamps();

            $table->unique(['type', 'user_id', 'session_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
