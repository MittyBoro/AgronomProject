<?php

namespace App\Livewire\Components;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Lazy;
use Livewire\Component;

class FilamentPanel extends Component
{
    public function render()
    {
        $isAdmin = Auth::user()?->is_admin;

        return $isAdmin
            ? view('livewire.components.filament-panel')
            : '<div></div>';
    }
}
