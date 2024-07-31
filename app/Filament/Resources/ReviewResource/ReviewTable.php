<?php

namespace App\Filament\Resources\ReviewResource;

use App\Filament\Resources\ReviewResource;
use App\Filament\Resources\ReviewResource\Pages\EditReview;
use App\Filament\Tables\IdColumn;
use App\Models\Review;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
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
                        fn (Review $record): string => $record->comment,
                    )
                    ->icon('heroicon-o-user')
                    ->color('info')
                    ->wrap()
                    ->searchable()
                    ->sortable()
                    ->url(
                        fn (Review $record): string => ReviewResource::getUrl(
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
                        fn (Review $record): string => ReviewResource::getUrl(
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
                        fn (?Review $record) => $record->likes >= 0
                            ? 'heroicon-o-hand-thumb-up'
                            : 'heroicon-o-hand-thumb-down',
                    ),
                //
                CheckboxColumn::make('is_approved')
                    ->label('Одобрено')
                    ->sortable(),
                //
                CheckboxColumn::make('is_pinned')
                    ->label('Закреплено')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
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
            ])
            ->filters([
                SelectFilter::make('products')
                    ->label('Товар')
                    ->searchable()
                    ->preload()
                    ->relationship(
                        'product',
                        'title',
                        fn (Builder $query): Builder => $query->whereHas(
                            'reviews',
                        ),
                    ),
                SelectFilter::make('users')
                    ->label('Пользователь')
                    ->searchable()
                    ->preload()
                    ->relationship(
                        'user',
                        'name',
                        fn (Builder $query): Builder => $query->whereHas(
                            'reviews',
                        ),
                    ),
            ])
            ->recordUrl(
                fn (Model $record): string => EditReview::getUrl([$record]),
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
            ->defaultSort('is_pinned', 'desc')
            ->persistSortInSession();
    }
}
