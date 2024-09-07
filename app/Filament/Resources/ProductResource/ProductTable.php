<?php

namespace App\Filament\Resources\ProductResource;

use App\Filament\Tables\IdColumn;
use App\Filament\Tables\MediaImageColumn;
use App\Filament\Tables\TableActions;
use App\Filament\Tables\TableBulkActions;
use App\Models\Product;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

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

                TextColumn::make('title')
                    ->label('Название')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->grow(1)
                    ->description(
                        fn(Product $record): string => $record->variations
                            ->pluck('title')
                            ->implode(', '),
                    ),

                //
                ColumnGroup::make('Отзывы', [
                    TextColumn::make('reviews_avg_rating')
                        ->label('Рейтинг')
                        ->badge()
                        ->icon('heroicon-o-star')
                        ->color('gray')
                        ->sortable()
                        ->avg('reviews', 'rating')
                        ->state(
                            fn($record): float => round(
                                $record->reviews_avg_rating,
                                2,
                            ),
                        )
                        ->toggleable()
                        ->url(
                            fn(Product $record): string => route(
                                'filament.theadmin.resources.reviews.index',
                                [
                                    'tableFilters[products][value]' =>
                                        $record->id,
                                ],
                            ),
                        ),

                    TextColumn::make('reviews_count')
                        ->label('Отзывы')
                        ->sortable()
                        ->counts('reviews')
                        ->state(fn($record) => $record->reviews_count)
                        ->toggleable()
                        ->url(
                            fn(Product $record): string => route(
                                'filament.theadmin.resources.reviews.index',
                                [
                                    'tableFilters[products][value]' =>
                                        $record->id,
                                ],
                            ),
                        ),
                ]),

                ColumnGroup::make('Цены', [
                    //
                    TextColumn::make('price')
                        ->label('Цена')
                        ->money('RUB', locale: 'ru_RU')
                        ->sortable(),
                    //
                    TextInputColumn::make('discount')
                        ->label('Скидка, %')
                        ->extraAttributes(['class' => 'max-w-24'])
                        ->alignment(Alignment::Center)
                        ->type('number')
                        ->rules(['required', 'numeric', 'min:0', 'max:100'])
                        ->sortable()
                        ->toggleable(),
                ]),

                //
                ToggleColumn::make('is_published')->label('Опубл.')->sortable(),
                //
                TextColumn::make('variations_min_stock')
                    ->label('Наличие')
                    ->min('variations', 'stock')
                    ->badge()
                    ->state(
                        fn(
                            Product $record,
                        ): string => $record->variations_min_stock
                            ? 'от ' . $record->variations_min_stock
                            : $record->stock,
                    )
                    ->sortable(
                        query: function (Builder $query, $direction): Builder {
                            return $query->orderBy(
                                DB::raw(
                                    'COALESCE(variations_min_stock, stock)',
                                ),
                                $direction,
                            );
                        },
                    )
                    ->color(
                        fn(
                            Product $record,
                        ): string => $record->variations_min_stock >
                        config('shop.warning_stock')
                            ? 'gray'
                            : 'danger',
                    ),

                TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->date('d.m.Y H:i:s')
                    ->dateTimeTooltip()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
                TrashedFilter::make(),

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
                    ->relationship('categories', 'title'),
            ])
            ->actions(TableActions::make())
            //
            ->bulkActions(TableBulkActions::make())
            //
            ->defaultSort('id', 'desc')
            ->striped();
    }
}
