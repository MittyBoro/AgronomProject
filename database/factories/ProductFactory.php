<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Configure the model factory.
     * After creating the model, add a media to it
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Product $category) {
            foreach (range(1, 2) as $v) {
                $category
                    ->addMediaFromUrl($this->faker->imageUrl())
                    ->usingName($category->slug)
                    ->toMediaCollection();
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
        $name = trim($this->faker->sentence(), '.');

        return [
            'slug' => Str::slug($name),
            'name' => $name,
            'description' => $this->faker->text(),

            'price' => $this->faker->numberBetween(500, 9000),
            'stock' => $this->faker->numberBetween(0, 1000),
            'is_published' => $this->faker->boolean(80),

            'meta_title' => $name,
            'meta_description' => $this->faker->text(),
        ];
    }
}
