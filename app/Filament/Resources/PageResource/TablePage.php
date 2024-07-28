<?php

namespace App\Filament\Resources\PageResource;

use App\Filament\Resources\PageResource\Pages\EditPage;
use App\Filament\Tables\IdColumn;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class TablePage
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
            ->recordUrl(
                fn (Model $record): string => EditPage::getUrl([$record]),
            )
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->iconButton()
                    ->url('/')
                    ->openUrlInNewTab('/'),
                Tables\Actions\EditAction::make()->button()->iconButton(false),
                Tables\Actions\DeleteAction::make()
                    ->button()
                    ->iconButton(false),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order_column')
            ->reorderable('order_column');
    }
}
