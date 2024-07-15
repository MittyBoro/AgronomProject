<?php

namespace App\Filament\Resources\CategoryResource\Tables;

use App\Filament\Resources\CategoryResource\Pages\EditCategory;
use App\Filament\Resources\ProductResource;
use App\Filament\Tables\IdColumn;
use App\Filament\Tables\MediaImageColumn;
use App\Models\Category;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

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
                TextColumn::make('name')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),
                //
                TextColumn::make('products_count')
                    ->label('Товары')
                    ->badge()
                    ->icon('heroicon-o-shopping-bag')
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
            ->recordUrl(
                fn(Model $record): string => EditCategory::getUrl([$record]),
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
            ->defaultSort('position')
            ->reorderable('position');
    }
}
