<?php

namespace App\Filament\Resources\CategoryResource;

use App\Filament\Resources\ProductResource;
use App\Filament\Tables\IdColumn;
use App\Filament\Tables\MediaImageColumn;
use App\Filament\Tables\TableActions;
use App\Filament\Tables\TableBulkActions;
use App\Models\Category;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoryTable
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
                TextColumn::make('products_count')
                    ->label('Товары')
                    ->badge()
                    ->icon('heroicon-o-shopping-bag')
                    ->color('gray')
                    ->counts('products')
                    ->sortable()
                    ->url(
                        fn(Category $record): string => ProductResource::getUrl(
                            'index',
                            [
                                'tableFilters' => [
                                    'categories' => [
                                        'value' => $record->id,
                                    ],
                                ],
                            ],
                        ),
                    ),
            ])
            ->filters([
                //
            ])
            //
            ->actions(TableActions::make())
            //
            ->bulkActions(TableBulkActions::make())
            //
            ->defaultSort('order_column')
            ->reorderable('order_column');
    }
}
