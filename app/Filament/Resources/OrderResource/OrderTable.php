<?php

namespace App\Filament\Resources\OrderResource;

use App\Enums\OrderStatusEnum;
use App\Filament\Resources\OrderResource;
use App\Filament\Tables\IdColumn;
use App\Models\Order;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrderTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                Grid::make(1)->schema([
                    // info
                    Panel::make([
                        // row: id, user date
                        Split::make([
                            //
                            IdColumn::make('id')
                                ->prefix('Заказ #')
                                ->sortable()
                                ->size(TextColumn\TextColumnSize::Large)
                                ->extraAttributes([
                                    'class' => 'font-bold',
                                ])
                                ->grow(false),
                            //
                            TextColumn::make('user.name')
                                ->label('Имя')
                                ->badge()
                                ->icon('heroicon-o-user')
                                ->color('info')
                                ->wrap()
                                ->searchable()
                                ->sortable()
                                // ->grow(false)
                                ->url(
                                    fn(
                                        Order $record,
                                    ): string => OrderResource::getUrl(
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
                            TextColumn::make('created_at')
                                ->label('Дата создания')
                                ->grow(false)
                                ->sortable()
                                ->date('d.m.Y H:i'),
                        ]),
                        // row: total price, count
                        Split::make([
                            // Total
                            TextColumn::make('total_price')
                                ->label('Стоимость')
                                ->money('RUB')
                                ->sortable()
                                ->size(TextColumn\TextColumnSize::Large)
                                ->grow(false)
                                ->extraAttributes([
                                    'class' => 'font-bold',
                                ]),
                            //
                            TextColumn::make('items_sum_quantity')
                                ->suffix(' шт.')
                                ->sum('items', 'quantity')
                                ->size(TextColumn\TextColumnSize::Medium)
                                ->extraAttributes([
                                    'class' => 'opacity-70',
                                ]),
                        ])->extraAttributes([
                            'class' => 'mt-2',
                        ]),
                    ])->extraAttributes([]),

                    // Status
                    Split::make([
                        //
                        IconColumn::make('id')
                            ->tooltip(
                                fn(?Order $record): string => __(
                                    'order.status.description.' .
                                        $record?->status?->value,
                                ),
                            )
                            ->icon(
                                fn(Order $record): string => match (
                                    $record->status->value
                                ) {
                                    'pending' => 'heroicon-o-clock',
                                    'paid' => 'heroicon-o-exclamation-circle',
                                    'processing' => 'heroicon-o-clock',
                                    'shipped' => 'heroicon-o-truck',
                                    'succeeded' => 'heroicon-o-check-circle',
                                    'canceled' => 'heroicon-o-x-circle',
                                    'refunded' => 'heroicon-o-x-circle',
                                    default => 'heroicon-o-clock',
                                },
                            )
                            ->color(
                                fn(Order $record): string => match (
                                    $record->status->value
                                ) {
                                    'pending' => 'warning',
                                    'paid' => 'info',
                                    'canceled' => 'gray',
                                    'refunded' => 'gray',
                                    'processing' => 'info',
                                    'shipped' => 'info',
                                    'Succeeded' => 'success',
                                    default => 'gray',
                                },
                            )
                            ->grow(false),

                        //
                        SelectColumn::make('status')
                            ->options(OrderStatusEnum::array())
                            ->label('Статус')
                            ->rules([
                                'required',
                                'in:' . implode(',', OrderStatusEnum::values()),
                            ])
                            ->sortable()
                            ->grow(true),
                    ])->extraAttributes([
                        'class' => 'mt-4 mb-2',
                    ]),
                ]),

                // информация
                Grid::make(1)
                    ->schema([
                        Panel::make([
                            Split::make([
                                TextColumn::make('id')
                                    ->icon('heroicon-o-information-circle')
                                    ->formatStateUsing(
                                        fn(?Order $record): string => __(
                                            'order.status.description.' .
                                                $record?->status?->value,
                                        ),
                                    ),
                            ]),
                        ]),
                        Panel::make([
                            ViewColumn::make('full_name')
                                ->label('Покупатель')
                                ->view(
                                    'filament.tables.columns.order-customer',
                                ),
                        ]),
                        Panel::make([
                            ViewColumn::make('price')
                                ->label('Сумма')
                                ->view('filament.tables.columns.order-price'),
                        ]),
                        Panel::make([
                            Stack::make([
                                ViewColumn::make('items')
                                    ->label('Содержание')
                                    ->view(
                                        'filament.tables.columns.order-items',
                                    ),
                            ]),
                        ]),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ])

            //
            ->contentGrid([
                'lg' => 1,
                'xl' => 2,
            ])

            //
            ->filters([
                SelectFilter::make('users')
                    ->label('Пользователь')
                    ->preload()
                    ->relationship(
                        'user',
                        'name',
                        fn(Builder $query): Builder => $query->whereHas(
                            'orders',
                        ),
                    ),

                SelectFilter::make('archive_status')
                    ->label('Архивация')
                    ->options([
                        'not_archived' => 'Основные',
                        'archived' => 'Архивированные',
                    ])
                    ->default('not_archived')
                    ->query(function (Builder $query, $state) {
                        if ($state['value'] === 'archived') {
                            return $query->isArchived();
                        }
                        if ($state['value'] === 'not_archived') {
                            return $query->isNotArchived();
                        }
                    }),
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options(OrderStatusEnum::array()),
            ])
            //
            ->modifyQueryUsing(
                fn(Builder $query) => $query->with(['items', 'user']),
            )
            ->recordClasses('fi-table-order-row')
            //
            ->actions([
                // в архив
                Action::make('archive')
                    ->label(
                        fn(Order $record): string => $record->is_archived
                            ? 'Восстановить'
                            : 'Архивировать',
                    )
                    ->color(
                        fn(Order $record): string => $record->is_archived
                            ? 'warning'
                            : 'gray',
                    )
                    ->icon('heroicon-m-archive-box')
                    ->button()
                    ->action(function (Order $record): void {
                        $record->update([
                            'is_archived' => !$record->is_archived,
                        ]);
                    }),
                DeleteAction::make()
                    ->visible(fn(Order $record): bool => $record->is_archived)
                    ->button(),
            ])
            //
            ->defaultSort('id', 'desc');
    }
}
