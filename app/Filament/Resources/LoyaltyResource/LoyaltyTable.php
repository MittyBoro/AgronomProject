<?php

namespace App\Filament\Resources\LoyaltyResource;

use App\Filament\Resources\UserResource;
use App\Filament\Tables\IdColumn;
use App\Filament\Tables\TableActions;
use App\Filament\Tables\TableBulkActions;
use App\Models\Loyalty;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LoyaltyTable
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
                    ->label('Название')
                    ->searchable()
                    ->sortable(),
                //
                TextColumn::make('percent')
                    ->label('Начисляемый процент')
                    ->suffix('%')
                    ->searchable()
                    ->sortable(),
                //
                TextColumn::make('min_order_sum')
                    ->label('Сумма заказов')
                    ->money('RUB')
                    ->searchable()
                    ->sortable(),

                //
                TextColumn::make('users_count')
                    ->label('Пользователи')
                    ->counts('users')
                    ->icon('heroicon-o-users')
                    ->badge()
                    ->color('gray')
                    ->sortable()
                    ->url(
                        fn(Loyalty $record): string => UserResource::getUrl(
                            'index',
                            [
                                'tableFilters' => [
                                    'loyalties' => [
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
            ->defaultSort('percent')
            ->striped();
    }
}
