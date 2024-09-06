<?php

namespace App\Livewire;

use App\Models\Page;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Livewire\Component;

class AboutPage extends Component
{
    use SEOToolsTrait;

    public ?Page $page;

    public array $breadcrumbs = [['', 'О нас']];

    public array $benefits = [];

    public function mount(): void
    {
        $this->page = Page::publicSelect()->whereSlug('about')->firstOrFail();

        $this->benefits = $this->page->attrs['list'][0] ?? [];

        $this->seo()
            ->setTitle($this->page->meta_title)
            ->setDescription($this->page->meta_description);
    }
}
