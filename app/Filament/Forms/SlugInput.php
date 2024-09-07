<?php

namespace App\Filament\Forms;

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SlugInput extends TextInput
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->required()
            ->label('Ссылка')
            ->maxLength(255)
            ->live(onBlur: true)
            ->afterStateUpdated(
                fn(Set $set, $state) => $set('slug', Str::slug($state)),
            )
            ->disabled(fn(Get $get): bool => !$get('slug_enabled'))
            ->afterStateHydrated(
                fn(?Model $record, Set $set) => $set('slug_enabled', !$record),
            )
            ->suffixAction(
                Action::make('lock')
                    ->label(
                        fn(Get $get): string => $get('slug_enabled')
                            ? 'Заблокировать'
                            : 'Разблокировать',
                    )
                    ->color('gray')
                    ->icon(
                        fn(Get $get) => $get('slug_enabled')
                            ? 'heroicon-o-lock-open'
                            : 'heroicon-o-lock-closed',
                    )
                    ->action(
                        fn(Set $set, Get $get): bool => $set(
                            'slug_enabled',
                            !$get('slug_enabled'),
                        ),
                    ),
            )
            ->hint(
                fn(Get $get): string => $get('slug_enabled') && $get('id')
                    ? 'Не рекомендуется менять ссылку!'
                    : '',
            )
            ->hintColor('danger')
            ->unique(ignoreRecord: true);
    }
}
