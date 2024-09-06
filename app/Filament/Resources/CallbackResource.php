<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CallbackResource\Pages;
use App\Models\Callback;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class CallbackResource extends Resource
{
    protected static ?string $model = Callback::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $label = 'Заявка на обратную связь';

    protected static ?string $pluralLabel = 'Заявки';

    protected static ?string $navigationLabel = 'Заявки на обратную связь';

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';

    protected static ?string $navigationGroup = 'Заявки';

    protected static ?int $navigationSort = 1;

    public static function table(Table $table): Table
    {
        return CallbackResource\CallbackTable::make($table);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return CallbackResource\CallbackInfolist::make($infolist);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCallbacks::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return cache_filament_badge(
            static::class,
            fn() => static::getModel()::where('is_archived', false)->count(),
        );
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'info';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email', 'phone', 'message'];
    }
}
