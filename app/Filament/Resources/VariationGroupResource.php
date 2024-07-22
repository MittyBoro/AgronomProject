<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VariationGroupResource\Pages;
use App\Models\VariationGroup;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VariationGroupResource extends Resource
{
    protected static ?string $model = VariationGroup::class;

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form->schema([
            //
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListVariationGroups::route('/'),
            'create' => Pages\CreateVariationGroup::route('/create'),
            'edit' => Pages\EditVariationGroup::route('/{record}/edit'),
        ];
    }
}
