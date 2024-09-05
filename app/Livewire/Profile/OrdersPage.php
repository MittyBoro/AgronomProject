<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.profile')]
class OrdersPage extends Component
{
    use WithPagination;

    public function render()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();
        $items = $user
            ->orders()
            ->with('items.media', 'items.product', 'bonuses')
            ->latest()
            ->paginate(perPage: 10);

        return view('livewire.profile.orders-page', ['items' => $items]);
    }
}
