<?php

namespace App\Filament\Resources\ArticleResource;

use App\Filament\Forms\BaseForm;
use App\Filament\Forms\MediaUpload;
use App\Filament\Forms\SlugInput;
use App\Models\Article;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;

class ArticleForm extends BaseForm
{
    public static function make(Form $form): Form
    {
        return $form->columns(1)->schema([
            Split::make([
                Tabs::make()
                    ->persistTabInQueryString()
                    ->tabs([
                        Tabs\Tab::make('main')
                            ->label('Основное')
                            ->schema(self::mainTabSchema()),
                        Tabs\Tab::make('seo')
                            ->label('SEO')
                            ->schema(self::seoSchema()),
                    ]),
                self::informationSection([
                    Toggle::make('is_published')->label('Опубликовано'),
                ])->grow(false),
            ])->from('xl'),
        ]);
    }

    private static function mainTabSchema(): array
    {
        return [
            TextInput::make('title')
                ->label('Название')
                ->live()
                ->afterStateUpdated(function (
                    Get $get,
                    Set $set,
                    ?string $old,
                    ?string $state,
                ): void {
                    if (($get('slug') ?? '') !== Str::slug($old)) {
                        return;
                    }

                    $set('slug', Str::slug($state));
                })
                ->required()
                ->maxLength(255),

            SlugInput::make('slug')->prefix('/articles/'),

            Textarea::make('description')
                ->label('Описание')
                ->rows(3)
                ->autosize()
                ->maxLength(2048),

            RichEditor::make('content')
                ->label('Текст')
                ->fileAttachmentsDirectory('attachments/articles')
                ->maxLength(65535),

            MediaUpload::make('media')
                ->label('Изображение (превью)')
                ->maxSize(1024 * 20)
                ->image()
                ->imageEditor()
                ->imageResizeMode('cover')
                ->imageCropAspectRatio('1:1')
                ->imageResizeTargetWidth(fn (): ?int => Article::$mediaMaxWidth)
                ->imageResizeTargetHeight(
                    fn (): ?int => Article::$mediaMaxWidth,
                ),
        ];
    }
}
