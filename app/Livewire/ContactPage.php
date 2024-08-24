<?php

namespace App\Livewire;

use App\Models\Page;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Livewire\Component;

class ContactPage extends Component
{
    use SEOToolsTrait;

    public Page $page;

    public array $breadcrumbs = [];

    public array $contacts = [];

    public function mount(): void
    {
        $this->page = Page::publicSelect()
            ->whereSlug('contacts')
            ->firstOrFail();

        $this->breadcrumbs[] = ['', $this->page->title];

        $this->contacts = $this->page->attrs['key_value'][0] ?? [];

        $this->seo()
            ->setTitle($this->page->meta_title)
            ->setDescription($this->page->meta_description);
    }
}
