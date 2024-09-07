<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropResource\Pages;
use App\Models\Prop;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class PropResource extends Resource
{
    protected static ?string $model = Prop::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $label = 'Настройки';

    protected static ?string $pluralLabel = 'Настройка';

    protected static ?string $navigationLabel = 'Настройки';

    protected static ?string $navigationGroup = 'Прочее';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return PropResource\PropForm::make($form);
    }

    public static function table(Table $table): Table
    {
        return PropResource\PropTable::make($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProps::route('/'),
        ];
    }
}
