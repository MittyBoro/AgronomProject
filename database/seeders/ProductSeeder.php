<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * К Product привязываем несколько категорий и вариаций
     * к каждому продукту добавляются свои вариации
     */
    public function run(): void
    {
        Product::factory(50)
            ->has(ProductVariation::factory()->count(rand(1, 5)), 'variations')
            ->create()
            ->each(function (Product $product) {
                $product
                    ->categories()
                    ->attach(Category::all()->random(rand(1, 3)));
            });
    }
}
