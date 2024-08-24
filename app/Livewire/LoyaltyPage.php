<?php

namespace App\Livewire;

use App\Models\Page;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Livewire\Component;

class LoyaltyPage extends Component
{
    use SEOToolsTrait;

    public Page $page;

    public array $breadcrumbs = [['', 'Бонусная программа']];

    public function mount(): void
    {
        $this->page = Page::publicSelect()->whereSlug('loyalty')->firstOrFail();

        $this->seo()
            ->setTitle($this->page->meta_title)
            ->setDescription($this->page->meta_description);
    }
}
