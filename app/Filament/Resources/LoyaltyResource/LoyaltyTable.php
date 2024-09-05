<?php

namespace App\Filament\Resources\LoyaltyResource;

use App\Filament\Tables\IdColumn;
use App\Filament\Tables\TableActions;
use App\Filament\Tables\TableBulkActions;
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
