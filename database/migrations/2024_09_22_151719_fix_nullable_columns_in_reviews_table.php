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
        Schema::table('reviews', function (Blueprint $table): void {
            // Удаляем существующие внешние ключи, чтобы можно было изменить столбцы
            $table->dropForeign(['product_id']);
            $table->dropForeign(['user_id']);

            // Изменяем product_id на nullable
            $table
                ->foreignId('product_id')
                ->nullable()
                ->change()
                ->constrained()
                ->nullOnDelete();

            // Изменяем user_id на nullable
            $table
                ->foreignId('user_id')
                ->nullable()
                ->change()
                ->constrained()
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table): void {
            //
        });
    }
};
