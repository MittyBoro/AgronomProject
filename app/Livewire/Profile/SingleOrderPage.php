<?php

namespace App\Livewire\Profile;

use App\Models\Order;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.profile')]
class SingleOrderPage extends Component
{
    use SEOToolsTrait;

    public Order $order;

    public function mount(Order $order): void
    {
        $user = Auth::user();
        if ($user->id !== $order->user_id) {
            abort(403);
        }

        $this->order = $order;
    }
}
