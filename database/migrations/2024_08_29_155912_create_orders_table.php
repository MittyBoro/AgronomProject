<?php

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Контактная информация
            $table->string('full_name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            // Адрес доставки
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();

            // Дополнительная информация
            $table->text('comment')->nullable();
            $table->boolean('save_info')->default(false);

            $table->text('delivery_comment')->nullable();

            $table
                ->foreignId('coupon_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->decimal('price', 10, 2);
            $table->decimal('total_price', 10, 2);

            $table->string('payment_method', 32);
            $table
                ->json('payment_data')
                ->default(new Expression('(JSON_ARRAY())'));
            $table
                ->string('status', 32)
                ->default(OrderStatusEnum::Pending->value);

            $table->boolean('is_archived')->default(false);
            $table->boolean('is_notified')->default(false);

            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE `orders` AUTO_INCREMENT = 100100;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
