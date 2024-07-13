<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Configure the model factory.
     * After creating the model, add a media to it
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Category $category) {
            $category
                ->addMediaFromUrl($this->faker->imageUrl())
                ->usingName($category->slug)
                ->toMediaCollection();
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
            'meta_title' => $name,
            'meta_description' => $this->faker->text(),
        ];
    }
}
