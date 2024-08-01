<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $label = 'Отзыв';

    protected static ?string $pluralLabel = 'Отзывы';

    protected static ?string $navigationLabel = 'Отзывы';

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left';

    protected static ?string $navigationGroup = 'Магазин';

    protected static ?int $navigationSort = 3;

    protected static ?int $newRecords = null;

    public static function form(Form $form): Form
    {
        return ReviewResource\ReviewForm::make($form);
    }

    public static function table(Table $table): Table
    {
        return ReviewResource\ReviewTable::make($table);
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
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getNewRecordsCount() ?: static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getNewRecordsCount() ? 'warning' : 'gray';
    }

    private static function getNewRecordsCount(): ?int
    {
        if (self::$newRecords === null) {
            self::$newRecords = static::getModel()::where('is_approved', 0)
                ->count();
        }

        return self::$newRecords;
    }
}
