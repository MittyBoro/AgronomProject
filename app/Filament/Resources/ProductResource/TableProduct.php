<?php

namespace App\Filament\Resources\ProductResource;

use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Filament\Tables\IdColumn;
use App\Filament\Tables\MediaImageColumn;
use App\Models\Product;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TableProduct
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
                    ->iconPosition(IconPosition::After)
                    ->icon(
                        fn (Product $record) => $record->has_variations
                            ? 'heroicon-s-list-bullet'
                            : null,
                    )
                    ->description(
                        fn (Product $record): string => $record->variations
                            ->pluck('title')
                            ->implode(', '),
                    ),

                //
                ToggleColumn::make('is_published')->label('Опубликовано'),

                //
                TextColumn::make('variations_min_stock')
                    ->label('Наличие')
                    ->min('variations', 'stock')
                    ->badge()
                    ->state(
                        fn (
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
                    ->relationship('categories', 'title'),
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
