<?php

namespace App\Livewire\Profile;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.profile')]
class LoyaltyPage extends Component
{
    public function render()
    {
        return view('livewire.profile.loyalty-page');
    }
}
