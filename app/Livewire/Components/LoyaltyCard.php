<?php

namespace App\Livewire\Components;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoyaltyCard extends Component
{
    public User $user;

    public ?string $id;

    public function mount(): void
    {
        $this->user = Auth::user();

        $this->id = preg_replace(
            '/\B(?=(\d{3})+(?!\d))/',
            ' ',
            mb_str_pad($this->user->id, 6, '0', STR_PAD_LEFT),
        );
    }

    public function render()
    {
        return view('livewire.components.loyalty-card');
    }
}
