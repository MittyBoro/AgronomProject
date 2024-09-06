<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $label = 'Статья';

    protected static ?string $pluralLabel = 'Статьи';

    protected static ?string $navigationLabel = 'Статьи';

    protected static ?string $navigationGroup = 'Прочее';

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return ArticleResource\ArticleForm::make($form);
    }

    public static function table(Table $table): Table
    {
        return ArticleResource\ArticleTable::make($table);
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'view' => Pages\ViewArticle::route('/{record}'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
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
            'content',
            'meta_title',
            'meta_description',
            'meta_keywords',
        ];
    }
}
