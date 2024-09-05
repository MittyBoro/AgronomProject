<?php

use App\Console\Commands\SetUserLoyaltyCommand;
use Illuminate\Support\Facades\Schedule;

// проставить уровень пользователям
Schedule::command(SetUserLoyaltyCommand::class)->hourlyAt('42');
