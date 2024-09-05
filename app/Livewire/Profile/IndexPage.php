<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.profile')]
class IndexPage extends Component
{
    public User $user;

    public Collection $orders;

    public function mount(): void
    {
        $this->user = Auth::user();

        $this->orders = $this->user
            ->orders()
            ->with('items.media', 'items.product', 'bonuses')
            ->latest()
            ->limit(5)
            ->get();
    }
}
