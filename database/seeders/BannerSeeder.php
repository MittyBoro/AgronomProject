<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Отрава со скидкой 7%',
                'url' => '/',
            ],
            [
                'title' => 'Отрава со скидкой 15%',
                'url' => '/',
            ],
        ];

        foreach ($pages as $page) {
            Banner::create($page);
        }
    }
}
