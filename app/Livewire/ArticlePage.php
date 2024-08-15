<?php

namespace App\Livewire;

use App\Models\Article;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Illuminate\Support\Collection;
use Livewire\Component;

class ArticlePage extends Component
{
    use SEOToolsTrait;

    public Article $article;
    public array $breadcrumbs = [['/articles', 'Статьи']];
    public Collection $similar;

    public function mount()
    {
        $this->setBreadcrumbs();
        $this->setSimilar();
    }

    private function setBreadcrumbs()
    {
        $this->breadcrumbs[] = ['', $this->article->title];
    }

    private function setSimilar()
    {
        $this->similar = Article::selectPublic()
            ->where('id', '!=', $this->article->id)
            ->limit(3)
            ->inRandomOrder()
            ->get();
    }
}
