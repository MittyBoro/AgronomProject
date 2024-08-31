<?php

namespace App\Filament\Resources\CouponResource;

use App\Filament\Tables\IdColumn;
use App\Filament\Tables\TableActions;
use App\Filament\Tables\TableBulkActions;
use App\Models\Coupon;
use Carbon\Carbon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class CouponTable
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
                TextColumn::make('code')->label('Код купона')->sortable(),
                //
                TextColumn::make('percentage')
                    ->label('Скидка')
                    ->suffix('%')
                    ->sortable()
                    ->numeric(),
                //
                TextColumn::make('count')->label('Количество')->sortable(),

                //
                ToggleColumn::make('is_active')->label('Активен')->sortable(),
                //
                TextColumn::make('expires_at')
                    ->label('Активен до')
                    ->sortable()
                    ->default('-')
                    ->formatStateUsing(
                        fn(string $state): ?string => $state === '-'
                            ? 'Бессрочно'
                            : Carbon::parse($state)?->format('d.m.Y H:i:s') ??
                                null,
                    )
                    ->tooltip(
                        fn(
                            Coupon $record,
                        ) => $record->expires_at?->diffForHumans(parts: 2),
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
            ->defaultSort('created_at', 'desc')
            ->striped();
    }
}
