<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Page;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ArticleListPage extends Component
{
    use SEOToolsTrait;
    use WithoutUrlPagination, WithPagination;

    public ?Page $page;

    public array $breadcrumbs = [['/articles', 'Статьи']];

    public string $title = 'Каталог';

    private int $perPage = 8;

    public function mount(): void
    {
        $this->mountPage();
    }

    private function mountPage(): void
    {
        $this->page = Page::publicSelect()
            ->whereSlug('articles')
            ->firstOrFail();

        $this->title = $this->page->title;

        $this->seo()
            ->setTitle($this->page->meta_title)
            ->setDescription($this->page->meta_description);
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
