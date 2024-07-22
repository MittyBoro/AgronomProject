<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * К Product привязываем несколько категорий и вариаций
     * к каждому продукту добавляются свои вариации
     */
    public function run(): void
    {
        Product::factory(50)->create();
    }
}
