<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends BaseFactory
{
    /**
     * Configure the model factory.
     * Добавляем изображения, категории и вариации к продукту
     */
    public function configure(): static
    {
        return $this->has(
            ProductVariation::factory()->count(rand(1, 5)),
            'variations',
        )->afterCreating(function (Product $product): void {
            $product->categories()->attach(Category::all()->random(rand(1, 3)));

            if ($this->hasMedia) {
                foreach (range(1, rand(1, 2)) as $v) {
                    $product
                        ->addMediaFromUrl(faker_media_url())
                        ->usingName($product->slug)
                        ->toMediaCollection();
                }
            }
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = trim(fake()->unique()->sentence(rand(2, 5)), '.');

        return [
            'slug' => Str::slug($name),
            'name' => $name,
            'description' => fake()->text(),

            'price' => round(fake()->numberBetween(500, 9000), -2),
            'stock' => fake()->numberBetween(0, 1000),
            'is_published' => fake()->boolean(80),

            'meta_title' => $name,
            'meta_description' => fake()->text(),
        ];
    }
}
