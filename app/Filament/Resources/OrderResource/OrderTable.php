<?php

namespace App\Filament\Resources\OrderResource;

use App\Enums\OrderStatusEnum;
use App\Filament\Resources\OrderResource;
use App\Filament\Tables\ArchiveAction;
use App\Filament\Tables\IdColumn;
use App\Models\Order;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Layout\Component;
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
use Illuminate\Http\Request;

class OrderTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                static::orderHeader(),
                static::orderBody()->collapsible()->collapsed(),
            ])
            //
            ->contentGrid([
                'lg' => 1,
                'xl' => 2,
            ])
            //
            ->filters(static::filters())
            //
            ->modifyQueryUsing(
                fn(Builder $query) => $query->with([
                    'items' => fn($query) => $query->with([
                        'product',
                        'variation',
                        'media',
                    ]),
                    'user',
                    'bonuses',
                    'coupon',
                ]),
            )
            //
            ->recordClasses('fi-table-order-row')
            //
            ->defaultPaginationPageOption(25)
            //
            ->actions([
                // в архив
                ArchiveAction::make('archive')->button(),
            ])
            //
            ->defaultSort('id', 'desc');
    }

    private static function filters(): array
    {
        return [
            //
            SelectFilter::make('archive_status')
                ->label('Список')
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
            //
            SelectFilter::make('status')
                ->label('Статус')
                ->options(OrderStatusEnum::array()),
            //
            SelectFilter::make('users')
                ->label('Пользователь')
                ->relationship('user', 'name', function (
                    Builder $query,
                    Request $request,
                ): Builder {
                    $userId =
                        $request->get('tableFilters')['users']['value'] ?? null;

                    return $query->when(
                        $userId,
                        fn($query) => $query->where('id', $userId),
                        fn($query) => $query->whereHas('orders'),
                    );
                }),
        ];
    }

    /**
     * Основная информация
     * id, пользователь, время
     * сумма ₽, кол-во
     * статус
     */
    private static function orderHeader(): Component
    {
        return Grid::make(1)->schema([
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
                            fn(Order $record): string => OrderResource::getUrl(
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
                        ->dateTimeTooltip()
                        ->date('d.m.Y H:i'),
                ]),
                // row: total price, count
                Split::make([
                    // Total
                    TextColumn::make('total_price')
                        ->label('Стоимость')
                        ->money('RUB')
                        ->sortable()
                        ->size(TextColumn\TextColumnSize::Medium)
                        ->grow(false)
                        ->extraAttributes([
                            'class' => 'font-bold',
                        ]),
                    //
                    TextColumn::make('items_sum_quantity')
                        ->suffix(' шт.')
                        ->sum('items', 'quantity')
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
        ]);
    }

    /**
     * Остальная информация о заказе
     */
    private static function orderBody(): Component
    {
        return Grid::make(1)->schema([
            // Подсказка для статуса
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

            // Покупатель
            Panel::make([
                ViewColumn::make('full_name')
                    ->label('Покупатель')
                    ->view('filament.tables.columns.order-customer'),
            ]),

            // Деньги
            Panel::make([
                ViewColumn::make('price')
                    ->label('Сумма')
                    ->view('filament.tables.columns.order-price'),
            ]),

            // Товары
            Panel::make([
                Stack::make([
                    ViewColumn::make('items')
                        ->label('Содержание')
                        ->view('filament.tables.columns.order-items'),
                ]),
            ]),
        ]);
    }
}
