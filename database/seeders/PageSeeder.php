<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Page::create([
            'slug' => 'index',
            'title' => 'Главная',
        ]);
        Page::create([
            'slug' => 'catalog',
            'title' => 'Каталог',
        ]);
        Page::create([
            'slug' => 'product',
            'title' => 'Товар',
        ]);
        Page::create([
            'slug' => 'loyalty',
            'title' => 'Бонусная программа',
        ]);
        Page::create([
            'slug' => 'articles',
            'title' => 'Статьи',
        ]);
        Page::create([
            'slug' => 'about',
            'title' => 'О нас',
        ]);
        Page::create([
            'slug' => 'contacts',
            'title' => 'Контакты',
        ]);
        Page::create([
            'slug' => 'simple-page',
            'title' => 'Простая страница',
        ]);
    }
}
