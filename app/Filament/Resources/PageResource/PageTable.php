<?php

namespace App\Filament\Resources\PageResource;

use App\Filament\Resources\PageResource\Pages\EditPage;
use App\Filament\Tables\IdColumn;
use App\Filament\Tables\TableActions;
use App\Filament\Tables\TableBulkActions;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PageTable
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
                TextColumn::make('title')
                    ->label('Заголовок')
                    ->searchable()
                    ->sortable(),
                //
                TextColumn::make('slug')
                    ->label('Ссылка')
                    ->formatStateUsing(fn (Model $record): string => '/' . $record->slug)
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            //
            ->recordUrl(
                fn (Model $record): string => EditPage::getUrl([$record]),
            )
            //
            ->actions(TableActions::make())
            //
            ->bulkActions(TableBulkActions::make())
            //
            ->defaultSort('order_column')
            ->reorderable('order_column');
    }
}
