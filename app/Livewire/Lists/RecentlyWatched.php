<?php

namespace App\Livewire\Lists;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class RecentlyWatched extends Component
{
    public ?Collection $items;

    public ?int $excludeId = null;

    public function mount(): void
    {
        $watchedArray = Cookie::get('user_watched')
            ? json_decode(Cookie::get('user_watched'))
            : [];

        if (count($watchedArray) < 3) {
            return;
        }
        if ($this->excludeId) {
            $watchedArray = array_diff($watchedArray, [$this->excludeId]);
        }
        $watchedArray = array_slice($watchedArray, -4);

        $this->items = Product::selectPublic()
            ->whereIn('id', $watchedArray)
            ->orderByRaw(
                'FIELD(id, ' .
                    implode(',', array_fill(0, count($watchedArray), '?')) .
                    ')',
                [$watchedArray],
            )
            ->get();
    }
}
