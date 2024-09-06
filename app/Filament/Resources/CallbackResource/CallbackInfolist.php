<?php

namespace App\Filament\Resources\CallbackResource;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Support\Enums\MaxWidth;
use Propaganistas\LaravelPhone\PhoneNumber;

class CallbackInfolist
{
    public static function make(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('name')->label('Имя'),
                TextEntry::make('email')
                    ->label('Email')
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->copyMessageDuration(1500),
                TextEntry::make('phone')
                    ->label('Телефон')
                    ->formatStateUsing(
                        fn(
                            ?PhoneNumber $state,
                        ): ?string => $state?->formatInternational(),
                    )
                    ->copyable()
                    ->copyMessage('Скопировано!')
                    ->copyMessageDuration(1500),
                TextEntry::make('message')
                    ->label('Сообщение')
                    ->prose()
                    ->maxWidth(MaxWidth::ExtraLarge),
                TextEntry::make('created_at')->label('Дата')->dateTime(),
            ])
            ->columns(1);
    }
}
