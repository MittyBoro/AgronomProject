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

            if ($this->loadMedia()) {
                foreach (range(1, rand(1, 2)) as $v) {
                    $product
                        ->addMediaFromUrl(faker_media_url(700))
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
        $title = trim($this->faker->unique()->sentence(rand(2, 5)), '.');

        return [
            'slug' => Str::slug($title),
            'title' => $title,
            'description' => $this->faker->text(),

            'price' => round($this->faker->numberBetween(500, 9000), -2),
            'stock' => $this->faker->numberBetween(0, 1000),
            'is_published' => $this->faker->boolean(80),
            'discount' => rand(0, 3) ? rand(10, 50) : 0,

            'meta_title' => $title,
            'meta_description' => $this->faker->text(),
        ];
    }
}
