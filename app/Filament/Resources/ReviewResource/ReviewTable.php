<?php

namespace App\Filament\Resources\ReviewResource;

use App\Filament\Resources\ReviewResource;
use App\Filament\Tables\IdColumn;
use App\Filament\Tables\TableActions;
use App\Filament\Tables\TableBulkActions;
use App\Models\Review;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

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
                    ->label('Пользователь')
                    ->badge()
                    ->icon('heroicon-o-user')
                    ->color('info')
                    ->wrap()
                    ->sortable()
                    ->extraAttributes([
                        'class' => 'max-w-32 truncate',
                    ])
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
                TextColumn::make('comment')
                    ->label('Текст')
                    ->wrap()
                    ->toggleable()
                    ->formatStateUsing(
                        fn(string $state): HtmlString => new HtmlString(
                            '<span class="leading-tight line-clamp-3 max-w-60">' .
                                nl2br($state) .
                                '</span>',
                        ),
                    ),
                //
                TextColumn::make('rating')
                    ->label('Рейтинг')
                    ->badge()
                    ->icon('heroicon-o-star')
                    ->color('gray')
                    ->toggleable()
                    ->sortable(),

                //
                TextColumn::make('product.title')
                    ->label('Товар')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-shopping-bag')
                    ->badge()
                    ->wrap()
                    ->extraAttributes([
                        'class' => 'max-w-32 truncate',
                    ])
                    ->color('gray')
                    ->toggleable()
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
                ToggleColumn::make('is_approved')
                    ->label('Одобрено')
                    ->toggleable()
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
                    ->dateTimeTooltip()
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
            ->defaultSort('id', 'desc')
            ->reorderable('order_column')
            ->striped();
    }
}
