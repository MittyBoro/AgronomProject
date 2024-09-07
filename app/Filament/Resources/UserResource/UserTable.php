<?php

namespace App\Filament\Resources\UserResource;

use App\Enums\RoleEnum;
use App\Filament\Resources\OrderResource;
use App\Filament\Tables\IdColumn;
use App\Filament\Tables\TableActions;
use App\Filament\Tables\TableBulkActions;
use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns(self::columns())
            //
            ->filters(self::filters())
            //
            ->modifyQueryUsing(fn(Builder $query) => $query->with(['loyalty']))
            //
            ->actions(TableActions::make())
            //
            ->bulkActions(TableBulkActions::make())
            //
            ->persistSortInSession()
            //
            ->defaultSort('id', 'desc')
            //
            ->striped();
    }

    private static function filters(): array
    {
        return [
            //
            Filter::make('has_orders')
                ->label('Есть заказы')
                ->query(fn(Builder $query) => $query->whereHas('orders')),
            //
            SelectFilter::make('loyalties')
                ->label('Бонусный уровень')
                ->relationship('loyalty', 'title'),
            //
            SelectFilter::make('role')
                ->label('Роль')
                ->options(RoleEnum::array()),
        ];
    }

    private static function columns(): array
    {
        return [
            //
            IdColumn::make('id'),
            //
            TextColumn::make('name')
                ->label('Имя')
                ->searchable()
                ->sortable()
                ->description(
                    fn(User $record): string => implode(
                        ' ',
                        array_filter([
                            $record->last_name,
                            $record->first_name,
                            $record->middle_name,
                        ]),
                    ),
                    position: 'below',
                )
                ->icon(
                    fn(User $record): ?string => $record->role ===
                    RoleEnum::Admin
                        ? 'heroicon-o-shield-exclamation'
                        : null,
                )
                ->iconPosition(IconPosition::After)
                ->iconColor('danger')
                ->tooltip(
                    fn(User $record): ?string => $record->role ===
                    RoleEnum::Admin
                        ? 'Администратор'
                        : null,
                )
                ->wrap(),
            //
            TextColumn::make('email')
                ->label('Email')
                ->icon(
                    fn(User $user): ?string => !$user->email_verified_at
                        ? 'heroicon-m-exclamation-triangle'
                        : null,
                )
                ->tooltip(
                    fn(User $record): ?string => !$record->email_verified_at
                        ? 'Email не подтверждён'
                        : null,
                )
                ->iconPosition(IconPosition::After)
                ->iconColor('warning')
                ->searchable()
                ->sortable()
                ->copyable()
                ->copyMessage('Email скопирован в буфер обмена'),

            //
            TextColumn::make('orders_count')
                ->label('Заказы')
                ->description(
                    fn(User $record): string => $record->orders_sum_total_price
                        ? 'На ' .
                            price_formatter($record->orders_sum_total_price) .
                            ' ₽'
                        : '',
                )
                ->counts([
                    'orders' => fn(Builder $query) => $query
                        ->where(fn(Builder $q) => $q->isCompleted())
                        ->orWhere(fn(Builder $q) => $q->isActive()),
                ])
                ->sum(
                    [
                        'orders' => fn(Builder $query) => $query
                            ->where(fn(Builder $q) => $q->isCompleted())
                            ->orWhere(fn(Builder $q) => $q->isActive()),
                    ],
                    'total_price',
                )
                ->badge()
                ->color('gray')
                ->icon('heroicon-o-shopping-bag')
                ->url(
                    fn(User $record): string => OrderResource::getUrl('index', [
                        'tableFilters' => [
                            'users' => [
                                'value' => $record->id,
                            ],
                        ],
                    ]),
                )
                ->sortable(),
            //
            TextColumn::make('bonuses_sum_amount')
                ->label('Бонусы')
                ->description(
                    fn(User $record): ?string => $record->loyalty?->title,
                )
                ->default(0)
                ->numeric()
                ->sum('bonuses', 'amount')
                ->sortable(),
            //
            TextColumn::make('created_at')
                ->label('Регистрация')
                ->date('d.m.Y')
                ->dateTimeTooltip()
                ->sortable(),
        ];
    }
}
