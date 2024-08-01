<?php

namespace App\Filament\Resources\ArticleResource;

use App\Filament\Resources\ArticleResource\Pages\EditArticle;
use App\Filament\Tables\IdColumn;
use App\Filament\Tables\MediaImageColumn;
use App\Filament\Tables\TableActions;
use App\Filament\Tables\TableBulkActions;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

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
                    ->date('d.m.Y H:i'),
            ])
            ->filters([
                //
            ])
            ->recordUrl(
                fn (Model $record): string => EditArticle::getUrl([$record]),
            )
            ->actions(TableActions::make())
            ->bulkActions(TableBulkActions::make())
            ->defaultSort('order_column')
            ->reorderable('order_column');
    }
}
