<?php

namespace App\Filament\Forms;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;

class BaseForm
{
    protected static function informationSection(
        array $components = [],
    ): Section {
        return Section::make([
            Placeholder::make('created_at')
                ->label('Дата создания')
                ->hidden(fn (?Model $record) => ! $record)
                ->content(
                    fn (?Model $record): string => (
                        $record?->created_at ?? now()
                    )->format('d.m.Y H:i'),
                ),
            Placeholder::make('updated_at')
                ->visible(fn (?Model $record): bool => (bool) $record)
                ->label('Последнее обновление')
                ->content(
                    fn (Model $record): string => $record->updated_at->format(
                        'd.m.Y H:i',
                    ),
                ),
            ...$components,
        ])->extraAttributes([
            'class' => 'md:min-w-80',
        ]);
    }

    protected static function seoSchema(): array
    {
        return [
            TextInput::make('meta_title')->maxLength(255),
            Textarea::make('meta_description')
                ->autosize()
                ->rows(3)
                ->maxLength(65535),
            TextInput::make('meta_keywords')->readOnly()->maxLength(255),
        ];
    }
}
