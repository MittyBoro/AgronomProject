<?php

namespace App\Filament\Forms;

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Model;

class SlugInput extends TextInput
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->required()
            ->label('Ссылка')
            ->maxLength(255)
            ->disabled(
                fn (Get $get, ?Model $record): bool => ! $get('slug_enabled') &&
                    $record,
            )
            ->suffixAction(
                fn (?Model $record) => $record
                    ? Action::make('lock')
                        ->color('gray')
                        ->icon(
                            fn (Get $get) => $get('slug_enabled')
                                ? 'heroicon-o-lock-open'
                                : 'heroicon-o-lock-closed',
                        )
                        ->action(
                            fn (Set $set, Get $get): bool => $set(
                                'slug_enabled',
                                ! $get('slug_enabled'),
                            ),
                        )
                    : null,
            )
            ->hint(
                fn (Get $get, ?Model $record): string => $get('slug_enabled') &&
                $record
                    ? 'Не рекомендуется менять ссылку!'
                    : '',
            )
            ->hintColor('danger')
            ->unique(ignoreRecord: true);
    }
}
