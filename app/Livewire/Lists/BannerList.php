<?php

namespace App\Livewire\Lists;

use App\Models\Banner;
use Illuminate\Support\Collection;
use Livewire\Component;

class BannerList extends Component
{
    public ?Collection $banners;

    public function mount(): void
    {
        $this->banners = Banner::selectPublic()->get();

        if ($this->banners->count() === 1) {
            $this->banners->merge($this->banners);
        }
    }
}
