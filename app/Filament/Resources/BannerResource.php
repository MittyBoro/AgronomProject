<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-square-2-stack';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $label = 'Баннер';

    protected static ?string $pluralLabel = 'Баннеры';

    protected static ?string $navigationLabel = 'Баннеры';

    protected static ?string $navigationGroup = 'Прочее';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return BannerResource\BannerForm::make($form);
    }

    public static function table(Table $table): Table
    {
        return BannerResource\BannerTable::make($table);
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
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::isPublished()->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'gray';
    }
}
