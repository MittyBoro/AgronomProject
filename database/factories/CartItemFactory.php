<?php

namespace Database\Factories;

use App\Models\CartItem;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CartItem>
 */
class CartItemFactory extends BaseFactory
{
    public function configure(): static
    {
        return $this->afterCreating(function (CartItem $cartItem): void {
            $variationId = $cartItem->product
                ->variations()
                ->inRandomOrder()
                ->first()->id;
            $cartItem->variations()->attach($variationId);
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first()->id;

        return [
            // protected $fillable = ['cart_id', 'product_id', 'quantity', 'price'];
            //
            'product_id' => $product,
            'quantity' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->numberBetween(100, 1000),
        ];
    }
}
