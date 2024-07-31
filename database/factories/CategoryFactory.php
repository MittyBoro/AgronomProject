<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends BaseFactory
{
    /**
     * Configure the model factory.
     * After creating the model, add a media to it
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Category $category): void {
            if ($this->hasMedia) {
                $category
                    ->addMediaFromUrl(faker_media_url())
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
        $title = trim($this->faker->unique()->sentence(rand(1, 3)), '.');

        return [
            'slug' => Str::slug($title),
            'title' => $title,
            'description' => $this->faker->text(),
            'meta_title' => $title,
            'meta_description' => $this->faker->text(),
        ];
    }
}
