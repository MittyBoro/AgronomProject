<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $recordTitleAttribute = 'full_name';

    protected static ?string $label = 'Заказ';

    protected static ?string $pluralLabel = 'Заказы';

    protected static ?string $navigationLabel = 'Заказы';

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Заявки';

    protected static ?int $navigationSort = 0;

    public static function table(Table $table): Table
    {
        return OrderResource\OrderTable::make($table);
    }

    public static function getRelations(): array
    {
        return [
                //
            ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            // 'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::isActive()->count() ?: '';
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'info';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'id',
            'full_name',
            'email',
            'phone',
            'postal_code',
            'city',
            'address',
            'comment',
            'delivery_comment',
            'status',
        ];
    }
}
