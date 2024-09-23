<?php

use App\Console\Commands\OrderCheckCommand;
use App\Console\Commands\SetUserLoyaltyCommand;
use App\Console\Commands\SitemapGenerateCommand;
use Illuminate\Support\Facades\Schedule;

// проставить уровень пользователям
Schedule::command(SetUserLoyaltyCommand::class)->hourlyAt('42');

// проверить оплату
Schedule::command(OrderCheckCommand::class)->everyFiveMinutes();

// сгенерировать карту сайта
Schedule::command(SitemapGenerateCommand::class)->dailyAt('04:20');
