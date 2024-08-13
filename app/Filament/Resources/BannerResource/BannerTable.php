<?php

namespace App\Filament\Resources\BannerResource;

use App\Filament\Tables\IdColumn;
use App\Filament\Tables\MediaImageColumn;
use App\Filament\Tables\TableActions;
use App\Filament\Tables\TableBulkActions;
use App\Models\Banner;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class BannerTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                //
                IdColumn::make('id')->toggleable(
                    isToggledHiddenByDefault: true,
                ),

                //
                MediaImageColumn::make('media'),

                //
                TextColumn::make('title')
                    ->label('Заголовок')
                    ->searchable()
                    ->sortable(),

                //
                ToggleColumn::make('is_published')->label('Опубликовано'),

                //
                TextColumn::make('published_until')
                    ->label('Отображать до')
                    ->sortable()
                    ->date('d.m.Y H:i')
                    ->badge()
                    ->tooltip(
                        fn(
                            Banner $record,
                        ) => $record->published_until?->diffForHumans(parts: 2),
                    )
                    ->color(
                        fn(Banner $record): string => $record->published_until <
                        now()
                            ? 'gray'
                            : 'success',
                    ),
            ])
            ->filters([
                //
            ])
            ->actions(TableActions::make())
            ->bulkActions(TableBulkActions::make())
            ->defaultSort('order_column')
            ->reorderable('order_column');
    }
}
