<?php

namespace App\Services\Seo;

use App\Models\Article;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapService
{
    private static Sitemap $sitemap;

    public static function generate()
    {
        self::$sitemap = Sitemap::create();

        self::setPages();
        self::setCategories();
        self::setProducts();
        self::setArticles();

        self::$sitemap->writeToFile(public_path('sitemap.xml'));

        return response(true);
    }

    /**
     * Установка страниц
     */
    private static function setPages(): void
    {
        $list = Page::select('id', 'slug', 'updated_at')->get();

        $list->each(function ($item): void {
            self::$sitemap->add(
                self::createUrl(
                    'page',
                    $item->slug,
                    in_array($item->slug, ['/', 'catalog'])
                        ? now()
                        : $item->updated_at,
                    in_array($item->slug, ['/', 'catalog'])
                        ? Url::CHANGE_FREQUENCY_WEEKLY
                        : Url::CHANGE_FREQUENCY_MONTHLY,
                    0.8,
                ),
            );
        });
    }

    /**
     * Установка категорий
     */
    private static function setCategories(): void
    {
        $list = Category::select('id', 'slug')->get();

        $list->each(function ($item): void {
            self::$sitemap->add(
                self::createUrl(
                    'category',
                    $item->slug,
                    now(),
                    Url::CHANGE_FREQUENCY_WEEKLY,
                    0.8,
                ),
            );
        });
    }

    /**
     * Установка товаров
     */
    private static function setProducts(): void
    {
        $list = Product::isPublished()
            ->select('id', 'slug', 'updated_at')
            ->get();
        $list->each(function ($item): void {
            self::$sitemap->add(
                self::createUrl(
                    'product',
                    $item->slug,
                    $item->updated_at,
                    Url::CHANGE_FREQUENCY_WEEKLY,
                    0.6,
                ),
            );
        });
    }

    /**
     * Установка статей
     */
    private static function setArticles(): void
    {
        $list = Article::select('id', 'slug', 'updated_at')->get();
        $list->each(function ($item): void {
            self::$sitemap->add(
                self::createUrl(
                    'article',
                    $item->slug,
                    $item->updated_at,
                    Url::CHANGE_FREQUENCY_MONTHLY,
                    0.4,
                ),
            );
        });
    }

    private static function createUrl(
        $routeName,
        $routeData,
        $lasModify,
        $frequency,
        $priority,
    ) {
        $createdUrl = Url::create(route($routeName, $routeData))
            ->setLastModificationDate($lasModify)
            ->setChangeFrequency($frequency)
            ->setPriority($priority);

        return $createdUrl;
    }
}
