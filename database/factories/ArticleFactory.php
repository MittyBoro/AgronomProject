<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends BaseFactory
{
    /**
     * Configure the model factory.
     * After creating the model, add a media to it
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Article $article): void {
            if ($this->hasMedia) {
                $article
                    ->addMediaFromUrl(faker_media_url())
                    ->usingName($article->slug)
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
        $title = trim($this->faker->unique()->sentence(rand(2, 5)), '.');

        return [
            'slug' => Str::slug($title),
            'title' => $title,
            'description' => $this->faker->text(),
            'content' => $this->faker->paragraphs(rand(4, 10), true),

            'is_published' => $this->faker->boolean(80),

            'meta_title' => $title,
            'meta_description' => $this->faker->text(),
        ];
    }
}
