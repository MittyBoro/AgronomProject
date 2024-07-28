<?php

use App\Enums\VariationGroupTypeEnum;
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
        Schema::create('variation_groups', function (Blueprint $table): void {
            $table->id();

            $table
                ->string('type', 16)
                ->default(VariationGroupTypeEnum::String->value);

            $table->string('title')->unique();

            $table->unsignedInteger('order_column')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variation_groups');
    }
};
