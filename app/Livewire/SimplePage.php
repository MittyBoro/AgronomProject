<?php

namespace App\Livewire;

use App\Models\Page;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Livewire\Component;

class SimplePage extends Component
{
    use SEOToolsTrait;

    public Page $page;
    public array $breadcrumbs = [];

    public function mount(Page $page)
    {
        $this->breadcrumbs[] = ['', $page->title];

        $this->seo()
            ->setTitle($page->meta_title)
            ->setDescription($page->meta_description);
    }
}
