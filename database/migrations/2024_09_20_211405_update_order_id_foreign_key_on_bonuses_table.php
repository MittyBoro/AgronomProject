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
        Schema::table('bonuses', function (Blueprint $table): void {
            $table->dropForeign(['order_id']);
            $table
                ->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bonuses', function (Blueprint $table): void {
            $table->dropForeign(['order_id']);
            $table
                ->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->nullOnDelete();
        });
    }
};
