<?php

namespace App\Livewire\Lists;

use App\Models\Loyalty;
use Illuminate\Support\Collection;
use Livewire\Component;

class LoyaltyList extends Component
{
    public Collection $list;

    public function mount(): void
    {
        $this->list = Loyalty::select(
            'id',
            'title',
            'description',
            'percentage',
        )
            ->orderBy('percentage')
            ->get();
    }
}
