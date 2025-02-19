<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $label = 'Категория';

    protected static ?string $pluralLabel = 'Категории';

    protected static ?string $navigationLabel = 'Категории';

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    protected static ?string $navigationGroup = 'Магазин';

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return CategoryResource\CategoryForm::make($form);
    }

    public static function table(Table $table): Table
    {
        return CategoryResource\CategoryTable::make($table);
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'view' => Pages\ViewCategory::route('/{record}'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return cache_filament_badge(
            static::class,
            fn() => static::getModel()::count(),
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
            'title',
            'slug',
            'description',
            'meta_title',
            'meta_description',
            'meta_keywords',
        ];
    }
}
