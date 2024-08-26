<?php

namespace App\Livewire\Profile;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.profile')]
class OrdersPage extends Component
{
    public function render()
    {
        return view('livewire.profile.orders-page');
    }
}
