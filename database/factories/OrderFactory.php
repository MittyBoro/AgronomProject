<?php

namespace Database\Factories;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Order $order): void {
            foreach (range(1, rand(3, 10)) as $i) {
                $product = Product::inRandomOrder()->selectPublic()->first();

                $variation = $product
                    ->variations()
                    ->with('group')
                    ->inRandomOrder()
                    ->first();

                $variationName = $variation
                    ? $variation->group->title . ' ' . $variation->title
                    : null;

                $order->items()->create([
                    'product_id' => $product->id,
                    'product_variation_id' => $variation?->id,
                    'media_id' => $product->media()->first()?->id,
                    'proudct_title' => $product->title,
                    'variation_title' => $variationName,
                    'quantity' => $this->faker->numberBetween(1, 10),
                    'price' => $product->total_price,
                ]);
            }
            $order->price = $order->items->sum(
                fn($item) => $item->price * $item->quantity,
            );
            $order->total_price = $order->price;
            $order->save();
        });
    }

    public function definition(): array
    {
        $user = User::find(1);
        $statuses = OrderStatusEnum::cases();
        $status = $statuses[array_rand($statuses)]->value;

        return [
            'user_id' => 1,
            'full_name' => $user->name,
            'email' => $user->email,
            'phone' =>
                '+7' . $this->faker->numberBetween(9000000000, 9999999999),

            'postal_code' => $this->faker->numberBetween(100000, 999999),
            'city' => $this->faker->city,
            'address' => $this->faker->address,
            'comment' => rand(0, 1) ? $this->faker->sentence(10) : null,
            'save_info' => $this->faker->boolean(80),
            'price' => $this->faker->numberBetween(500, 5000),
            'total_price' => $this->faker->numberBetween(500, 5000),
            'payment_method' => 'Наличные',
            'status' => $status,
            'is_archived' => $this->faker->boolean(10),
        ];
    }
}
