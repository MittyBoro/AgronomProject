<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.profile')]
class IndexPage extends Component
{
    public User $user;

    public function mount(): void
    {
        $this->user = Auth::user();
    }
}
