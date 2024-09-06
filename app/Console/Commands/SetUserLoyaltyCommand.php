<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class SetUserLoyaltyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:set-loyalty';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Установка уровня loyalty у пользователя';

    /**
     * Выбрать всех, у кого не выставился уровень
     * или последний заказ был обновлен менее 3 часов назад (с запасом)
     */
    public function handle(): void
    {
        User::whereHas(
            'orders',
            fn($q) => $q->where('updated_at', '>=', Carbon::now()->subHours(3)),
        )
            ->orWhereNull('loyalty_id')
            ->cursor()
            ->each(function (User $user): void {
                $user->setLoyalty();
            });
    }
}
