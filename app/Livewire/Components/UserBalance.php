<?php

namespace App\Livewire\Components;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserBalance extends Component
{
    public ?string $balance;

    public string $class = '';

    public function mount(): void
    {
        $this->balance = Auth::user()?->balance;
    }
}
