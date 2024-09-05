<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.profile')]
class LoyaltyPage extends Component
{
    public User $user;

    public int $toNextLevel = 0;

    public int $toNextLevelPercent = 100;

    public function mount(): void
    {
        $this->user = Auth::user();

        $this->setLoyaltyLevel();
    }

    private function setLoyaltyLevel(): void
    {
        // сумма всех покупок
        $sumOfOrders = (int) $this->user
            ->orders()
            ->isCompleted()
            ->sum('total_price');

        // следующий уровень лояльности
        $nextLevel = $this->user->loyalty?->nextLevel();

        if (!$nextLevel) {
            $this->toNextLevel = -1;
        } else {
            $this->toNextLevel = max(
                0,
                $nextLevel->min_order_sum - $sumOfOrders,
            );

            $this->toNextLevelPercent = min(
                100,
                ($sumOfOrders * 100) / $nextLevel->min_order_sum,
            );
        }
    }
}
