<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $label = 'Страница';

    protected static ?string $pluralLabel = 'Страницы';

    protected static ?string $navigationLabel = 'Страницы';

    protected static ?string $navigationGroup = 'Прочее';

    public static function form(Form $form): Form
    {
        return PageResource\FormPage::make($form);
    }

    public static function table(Table $table): Table
    {
        return PageResource\TablePage::make($table);
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
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
