<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Models\Coupon;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $label = 'Купон';

    protected static ?string $pluralLabel = 'Купоны';

    protected static ?string $navigationLabel = 'Купоны';

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationGroup = 'Магазин';

    protected static ?int $navigationSort = 40;

    public static function form(Form $form): Form
    {
        return CouponResource\CouponForm::make($form);
    }

    public static function table(Table $table): Table
    {
        return CouponResource\CouponTable::make($table);
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
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::isActive()->count();
    }
}
