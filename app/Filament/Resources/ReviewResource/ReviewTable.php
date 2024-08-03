<?php

namespace App\Filament\Resources\ReviewResource;

use App\Filament\Resources\ReviewResource;
use App\Filament\Resources\ReviewResource\Pages\EditReview;
use App\Filament\Tables\IdColumn;
use App\Filament\Tables\TableActions;
use App\Filament\Tables\TableBulkActions;
use App\Models\Review;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ReviewTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                //
                IdColumn::make('id')->toggleable(),

                //
                TextColumn::make('name')
                    ->label('Заголовок')
                    ->badge()
                    ->description(
                        fn(Review $record): string => $record->comment,
                    )
                    ->icon('heroicon-o-user')
                    ->color('info')
                    ->wrap()
                    ->searchable()
                    ->sortable()
                    ->url(
                        fn(Review $record): string => ReviewResource::getUrl(
                            'index',
                            [
                                'tableFilters' => [
                                    'users' => [
                                        'value' => $record->user_id,
                                    ],
                                ],
                            ],
                        ),
                    ),

                //
                TextColumn::make('rating')
                    ->label('Рейтинг')
                    ->badge()
                    ->icon('heroicon-o-star')
                    ->color('gray')
                    ->sortable(),

                //
                TextColumn::make('product.title')
                    ->label('Товар')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-shopping-bag')
                    ->badge()
                    ->wrap()
                    ->color('gray')
                    ->url(
                        fn(Review $record): string => ReviewResource::getUrl(
                            'index',
                            [
                                'tableFilters' => [
                                    'products' => [
                                        'value' => $record->product_id,
                                    ],
                                ],
                            ],
                        ),
                    ),
                TextColumn::make('likes')
                    ->label('Лайки')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->icon(
                        fn(?Review $record) => $record->likes >= 0
                            ? 'heroicon-o-hand-thumb-up'
                            : 'heroicon-o-hand-thumb-down',
                    ),
                //
                CheckboxColumn::make('is_approved')
                    ->label('Одобрено')
                    ->sortable(),
                //
                ToggleColumn::make('is_pinned')
                    ->label('Закреплено')
                    ->sortable()
                    ->toggleable()
                    ->sortable(
                        query: function (
                            Builder $query,
                            string $direction,
                        ): Builder {
                            return $query
                                ->orderBy('is_pinned', $direction)
                                ->orderBy('id', $direction);
                        },
                    ),

                //created_at
                TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->sortable()
                    ->toggleable()
                    ->date('d.m.Y H:i'),
            ])
            ->filters([
                SelectFilter::make('products')
                    ->label('Товар')
                    ->searchable()
                    ->preload()
                    ->relationship(
                        'product',
                        'title',
                        fn(Builder $query): Builder => $query->whereHas(
                            'reviews',
                        ),
                    ),
                SelectFilter::make('users')
                    ->label('Пользователь')
                    ->preload()
                    ->relationship(
                        'user',
                        'name',
                        fn(Builder $query): Builder => $query->whereHas(
                            'reviews',
                        ),
                    ),
                SelectFilter::make('is_approved')
                    ->label('Одобрение')
                    ->options([
                        1 => 'Одобренные',
                        0 => 'Не одобренные',
                    ]),
                SelectFilter::make('is_pinned')
                    ->label('Закреплено')
                    ->options([
                        1 => 'Только закрепленные',
                    ]),
            ])
            //
            ->recordUrl(
                fn(Model $record): string => EditReview::getUrl([$record]),
            )
            //

            ->recordClasses(
                fn(Model $record) => $record->is_pinned
                    ? 'border-l-4 bg-gray-500/5'
                    : '',
            )
            //
            ->actions(TableActions::make())
            //
            ->bulkActions(TableBulkActions::make())
            //
            ->persistSortInSession()
            ->defaultSort(
                fn($query) => $query
                    ->orderBy('is_pinned', 'desc')
                    ->orderBy('order_column'),
            )
            ->reorderable('order_column');
    }
}
