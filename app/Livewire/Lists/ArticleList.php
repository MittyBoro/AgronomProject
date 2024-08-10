<?php

namespace App\Livewire\Lists;

use Illuminate\Support\Collection;
use Livewire\Component;

class ArticleList extends Component
{
    public ?Collection $articles;

    public ?string $pretitle;
    public ?string $title;
    public ?array $button;

    public function mount(Collection $articles)
    {
        $this->articles = $articles;
    }

    public function render()
    {
        return view('livewire.article.list');
    }
}
