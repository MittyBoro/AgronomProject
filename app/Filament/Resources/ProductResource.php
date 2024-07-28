<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $label = 'Товар';

    protected static ?string $pluralLabel = 'Товары';

    protected static ?string $navigationLabel = 'Товары';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Магазин';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return ProductResource\FormProduct::make($form);
    }

    public static function table(Table $table): Table
    {
        return ProductResource\TableProduct::make($table);
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'gray';
    }
}
