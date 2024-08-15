<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Page;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class ArticleListPage extends Component
{
    use WithPagination, WithoutUrlPagination;
    use SEOToolsTrait;

    public array $breadcrumbs = [['/articles', 'Статьи']];
    public string $title = 'Каталог';

    private int $perPage = 8;

    public function mount()
    {
        $this->mountPage();
    }

    private function mountPage(): void
    {
        $page = Page::publicSelect()->whereSlug('articles')->firstOrFail();
        $this->title = $page->title;

        $this->seo()
            ->setTitle($page->meta_title)
            ->setDescription($page->meta_description);
    }

    private function setJsonLd(array $articles): void
    {
        foreach ($articles as $article) {
            $this->seo()
                ->jsonLdMulti()
                ->newJsonLd()
                ->addValue('itemListElement', [
                    '@type' => 'Article',
                    'headline' => $article->title,
                    'description' => $article->description,
                    'datePublished' => $article->created_at->format('Y-m-d'),
                    'image' => [$article->preview],
                ]);
        }
    }

    public function render()
    {
        $articles = Article::selectPublic()->paginate(perPage: $this->perPage);
        $this->setJsonLd($articles->items());

        return view('livewire.article-list-page', compact('articles'));
    }
}
