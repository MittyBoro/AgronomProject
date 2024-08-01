<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\CartItem;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends BaseFactory
{
    public function configure(): static
    {
        return $this->afterCreating(function (Cart $cart): void {
            $items = CartItem::factory(rand(5, 15))->create([
                'cart_id' => $cart->id,
            ]);
            $cart->items()->attach($items);
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
        ];
    }
}
