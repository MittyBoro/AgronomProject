<?php

namespace App\Filament\Resources\ProductResource\Tables;

use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Filament\Tables\IdColumn;
use App\Filament\Tables\MediaImageColumn;
use App\Models\Product;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ProductTable
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
                MediaImageColumn::make('preview'),

                //
                TextColumn::make('name')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),
                //
                ToggleColumn::make('is_published')->label('Опубликовано'),

                //
                TextColumn::make('stock')
                    ->label('Наличие')
                    ->badge()
                    ->sortable()
                    ->size('xs')
                    ->color(
                        fn (Product $record): string => $record->stock > 10
                            ? 'gray'
                            : 'danger',
                    ),

                //
                TextColumn::make('price')
                    ->label('Цена')
                    ->money('RUB', locale: 'ru_RU')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->date('d.m.Y H:i:s')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
                SelectFilter::make('is_published')
                    ->label('Опубликовано')
                    ->options([
                        '1' => 'Опубликовано',
                        '0' => 'Не опубликовано',
                    ])
                    ->preload(),

                SelectFilter::make('categories')
                    ->label('Категория')
                    ->relationship('categories', 'name'),
            ])
            ->recordUrl(
                fn (Model $record): string => EditProduct::getUrl([$record]),
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
            ->defaultSort('id', 'desc');
    }
}
