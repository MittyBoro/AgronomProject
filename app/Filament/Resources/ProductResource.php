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
        return ProductResource\ProductForm::make($form);
    }

    public static function table(Table $table): Table
    {
        return ProductResource\ProductTable::make($table);
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
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return cache_filament_badge(
            static::class,
            fn() => static::getModel()::isPublished()->count(),
        );
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'gray';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'id',
            'slug',
            'title',
            'description',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'variations.title',
        ];
    }
}
