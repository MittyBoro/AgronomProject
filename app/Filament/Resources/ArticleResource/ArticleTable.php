<?php

namespace App\Filament\Resources\ArticleResource;

use App\Filament\Tables\IdColumn;
use App\Filament\Tables\MediaImageColumn;
use App\Filament\Tables\TableActions;
use App\Filament\Tables\TableBulkActions;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ArticleTable
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

                //created_at
                TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->sortable()
                    ->dateTimeTooltip()
                    ->date('d.m.Y'),
            ])
            ->filters([
                //
            ])
            ->actions(TableActions::make())
            ->bulkActions(TableBulkActions::make())
            ->defaultSort('order_column')
            ->reorderable('order_column')
            ->striped();
    }
}
