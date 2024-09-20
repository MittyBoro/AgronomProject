<?php

use App\Console\Commands\OrderCheckCommand;
use App\Console\Commands\SetUserLoyaltyCommand;
use Illuminate\Support\Facades\Schedule;

// проставить уровень пользователям
Schedule::command(SetUserLoyaltyCommand::class)->hourlyAt('42');

// проверить оплату
Schedule::command(OrderCheckCommand::class)->everyFiveMinutes();
