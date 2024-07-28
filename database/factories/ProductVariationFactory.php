<?php

namespace Database\Factories;

use App\Models\VariationGroup;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariation>
 */
class ProductVariationFactory extends BaseFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $variation = VariationGroup::inRandomOrder()->first();
        $rand = rand(1, 10);

        return [
            'variation_group_id' => $variation->id,
            'title' => $rand * 100 . ($variation->title === 'Вес' ? ' г.' : 'мл.'),
            'order_column' => $rand,
            'price_modifier' => rand(-1, 1) * rand(0, 4) * 100,
            'stock' => fake()->numberBetween(0, 1000),
        ];
    }
}
