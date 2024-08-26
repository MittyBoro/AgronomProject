<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoyaltyResource\Pages;
use App\Models\Loyalty;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class LoyaltyResource extends Resource
{
    protected static ?string $model = Loyalty::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $label = 'Бонусная система';

    protected static ?string $pluralLabel = 'Бонусные системы';

    protected static ?string $navigationLabel = 'Бонусная система';

    protected static ?string $navigationGroup = 'Магазин';

    protected static ?int $navigationSort = 30;

    public static function form(Form $form): Form
    {
        return LoyaltyResource\LoyaltyForm::make($form);
    }

    public static function table(Table $table): Table
    {
        return LoyaltyResource\LoyaltyTable::make($table);
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
            'index' => Pages\ListLoyalties::route('/'),
            'create' => Pages\CreateLoyalty::route('/create'),
            'edit' => Pages\EditLoyalty::route('/{record}/edit'),
        ];
    }
}
