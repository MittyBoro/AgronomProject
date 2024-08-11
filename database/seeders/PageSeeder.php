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
        $pages = [
            [
                'slug' => '/',
                'title' => 'Главная',
                'blocks' => [
                    [
                        'data' => [
                            'value' => [
                                'home_title' =>
                                    'Тут будет какой-то оффер мол лучшая отрава для огорода',
                                'home_description' =>
                                    'Lorem ipsum dolor sit amet consectetur. Commodo aliquam quam netus augue. Egestas mattis fames orci malesuada.',
                            ],
                        ],
                        'type' => 'key_value',
                    ],
                ],
            ],
            ['slug' => 'catalog', 'title' => 'Каталог'],
            ['slug' => 'product', 'title' => 'Товар'],
            ['slug' => 'loyalty', 'title' => 'Бонусная программа'],
            ['slug' => 'articles', 'title' => 'Статьи'],
            ['slug' => 'about', 'title' => 'О нас'],
            ['slug' => 'contacts', 'title' => 'Контакты'],
            ['slug' => 'simple-page', 'title' => 'Простая страница'],
        ];

        foreach ($pages as $page) {
            Page::create($page);
        }
    }
}
