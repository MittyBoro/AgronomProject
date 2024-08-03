<?php

use App\Models\Page;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table): void {
            $table->id();

            $table->string('slug')->index()->unique();

            $table->string('title');
            $table->text('content')->nullable();

            $table->string('meta_title', 255)->nullable();
            $table->string('meta_description', 1024)->nullable();
            $table->string('meta_keywords', 512)->nullable();

            $table->json('fields')->default(new Expression('(JSON_ARRAY())'));

            $table->string('layout')->nullable();

            $table->unsignedInteger('order_column')->default(0);

            $table->timestamps();
        });

        $pages = [
            [
                'slug' => 'index',
                'title' => 'Главная',
                'fields' => [
                    'home_title' => 'Тут будет какой-то офер мол лучшая отрава для огорода',
                    'home_description' => 'Lorem ipsum dolor sit amet consectetur. Commodo aliquam quam netus augue. Egestas mattis fames orci malesuada.',
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
