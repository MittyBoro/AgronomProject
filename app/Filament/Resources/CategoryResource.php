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

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return CategoryResource\FormCategory::make($form);
    }

    public static function table(Table $table): Table
    {
        return CategoryResource\TableCategory::make($table);
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
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
