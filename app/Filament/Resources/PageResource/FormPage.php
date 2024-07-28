<?php

namespace App\Filament\Resources\PageResource;

use App\Filament\Forms\BaseForm;
use App\Filament\Forms\MediaUpload;
use App\Filament\Forms\SlugInput;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;

class FormPage extends BaseForm
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
                self::informationSection()->grow(false),
            ])->from('xl'),
        ]);
    }

    private static function mainTabSchema(): array
    {
        return [
            //
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

            //
            SlugInput::make('slug')->prefix('/'),

            //
            RichEditor::make('content')->label('Контент')->maxLength(65535),

            //
            KeyValue::make('fields')->label('Дополнительные поля')->reorderable(),

            //
            MediaUpload::make('media')
                ->label('Дополнительные файлы')
                ->hint('По необходимости')
                ->previewable(false)
                ->maxSize(1024 * 20)
                ->multiple(),
        ];
    }
}
