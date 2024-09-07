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
        Schema::create('props', function (Blueprint $table): void {
            $table->id();

            $table->string('type');
            $table->string('key')->unique()->index();
            $table->text('value')->nullable();

            $table->string('group')->nullable();
            $table->string('title')->nullable();
            $table->string('description')->nullable();

            $table->unsignedInteger('order_column')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('props');
    }
};
