<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
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
        $ids = Cart::pluck('user_id')->toArray();
        $user = User::inRandomOrder()->whereNotIn('id', $ids)->first();

        return [
            'user_id' => $user->id,
        ];
    }
}
