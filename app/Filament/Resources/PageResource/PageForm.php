<?php

namespace App\Filament\Resources\PageResource;

use App\Filament\Forms\BaseForm;
use App\Filament\Forms\MediaUpload;
use App\Filament\Forms\SlugInput;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;

class PageForm extends BaseForm
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
            Builder::make('blocks')
                ->label('Дополнительные данные')
                // скрыть кнопки
                ->collapseAllAction(fn(Action $action) => $action->hidden())
                ->expandAllAction(fn(Action $action) => $action->hidden())
                ->blocks([
                    // Простой текст
                    Builder\Block::make('text')
                        ->label('Текст')
                        ->maxItems(1)
                        ->schema([
                            Textarea::make('value')->label('')->autosize(),
                        ]),
                    // Список значение
                    Builder\Block::make('list')
                        ->label('Список')
                        ->schema([
                            Repeater::make('value')
                                ->label('')
                                ->addActionLabel('Добавить')
                                ->simple(TextInput::make('text')),
                        ]),

                    // Список ключ-значение
                    Builder\Block::make('key_value')
                        ->label('Ключ-значение')
                        ->schema([
                            KeyValue::make('value')->label('')->reorderable(),
                        ]),

                    // Файлы
                    Builder\Block::make('media')
                        ->label('Файлы')
                        ->schema([
                            MediaUpload::make('value')
                                ->label('')
                                ->previewable(false)
                                ->maxSize(1024 * 20)
                                ->multiple(),
                        ]),
                ])
                ->addActionLabel('Добавить блок')
                ->blockNumbers(false)
                ->collapsible(),
        ];
    }
}
