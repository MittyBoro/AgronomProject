<?php

namespace App\Filament\Resources\ProductResource\Forms;

use App\Filament\Forms\BaseForm;
use App\Filament\Forms\MediaUpload;
use App\Filament\Forms\SlugInput;
use App\Filament\Resources\ProductResource;
use App\Models\Product;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Support\Enums\MaxWidth;
use Filament\Support\RawJs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductForm extends BaseForm
{
    public static function make(Form $form): Form
    {
        return $form->columns(1)->schema([
            Split::make([
                //
                Tabs::make()
                    ->persistTabInQueryString()
                    ->tabs([
                        //
                        Tabs\Tab::make('main')
                            ->label('Основное')
                            ->schema(self::mainTabSchema()),
                        //
                        Tabs\Tab::make('price')
                            ->label('Цены')
                            ->schema(self::priceTabSchema()),
                        //
                        Tabs\Tab::make('seo')
                            ->label('SEO')
                            ->schema(parent::seoSchema()),
                    ]),
                //
                Grid::make(['default' => '1'])
                    ->schema([
                        self::detailsSection(),
                        parent::informationSection(),
                    ])
                    ->extraAttributes([
                        'class' => 'xl:max-w-md',
                    ])
                    ->grow(false),
            ])->from('xl'),
        ]);
    }

    private static function mainTabSchema(): array
    {
        return [
            TextInput::make('name')
                ->label('Название')
                ->live()
                ->afterStateUpdated(function (
                    Get $get,
                    Set $set,
                    ?string $old,
                    ?string $state,
                ) {
                    if (($get('slug') ?? '') !== Str::slug($old)) {
                        return;
                    }

                    $set('slug', Str::slug($state));
                })
                ->required()
                ->maxLength(255),

            SlugInput::make('slug')->prefix('/product/'),

            RichEditor::make('description')
                ->label('Описание')
                ->fileAttachmentsDirectory('attachments/categories')
                ->maxLength(65535),

            MediaUpload::make('media')
                ->label('Изображения')
                ->multiple()
                ->maxFiles(10)
                ->maxSize(1024 * 20)
                ->image()
                ->imageEditor()
                ->imageResizeMode('cover')
                ->imageCropAspectRatio('1:1')
                ->imageResizeTargetWidth(fn(): ?int => Product::$mediaMaxWidth)
                ->imageResizeTargetHeight(
                    fn(): ?int => Product::$mediaMaxWidth,
                ),
        ];
    }

    private static function priceTabSchema(): array
    {
        return [
            //
            TextInput::make('price')
                ->default(0)
                ->label('Базовая цена')
                ->live()
                ->prefix('₽')
                ->minValue(0)
                ->maxValue(42949672)
                ->numeric()
                ->mask(RawJs::make('$money($input, `.`, ` `)'))
                ->stripCharacters([' '])
                ->hint(
                    fn(Get $get): ?string => !$get('price')
                        ? 'Цена не установлена!'
                        : '',
                )
                ->hintColor('danger'),
            TextInput::make('stock')
                ->default(0)
                ->label('Остаток на складе')
                ->suffix('шт.')
                ->minValue(0)
                ->maxValue(9999999)
                ->integer()
                ->live()
                ->hint(
                    fn(Get $get): ?string => $get('stock') < 10
                        ? (!$get('stock')
                            ? 'Закончился'
                            : 'Заканчивается')
                        : '',
                )
                ->hintColor('warning'),

            //
            self::priceRepeater(),
        ];
    }

    private static function priceRepeater(): Repeater
    {
        return Repeater::make('variations')
            ->label('Вариации')
            ->defaultItems(1)
            ->relationship()
            ->addActionLabel('Добавить вариацию')
            ->columns(2)
            ->orderColumn('position')
            ->itemLabel(fn(array $state): ?string => $state['name'] ?? null)
            ->collapsible()
            ->cloneable()
            ->collapseAllAction(fn(Action $action) => $action->hidden())
            ->expandAllAction(fn(Action $action) => $action->hidden())
            ->schema([
                //
                TextInput::make('name')
                    ->label('Название')
                    ->live()
                    ->columnSpan(2)
                    ->hidden(fn(Get $get): bool => !$get('is_editing')),
                //
                TextInput::make('price_modifier')
                    ->default(0)
                    ->label('Модификатор цены')
                    ->prefix('₽')
                    ->numeric()
                    ->mask(RawJs::make('$money($input, `.`, ` `)'))
                    ->stripCharacters([' '])
                    ->live()
                    ->hint(
                        fn(Get $get): ?string => 'Итог: ' .
                            price_formatter(static::variationPrice($get)) .
                            '₽',
                    )
                    ->hintColor(
                        fn(Get $get): ?string => static::variationPrice($get) <=
                        0
                            ? 'danger'
                            : null,
                    ),
                //
                TextInput::make('stock')
                    ->default(0)
                    ->label('Остаток на складе')
                    ->suffix('шт.')
                    ->minValue(0)
                    ->maxValue(9999999)
                    ->integer()
                    ->live()
                    ->hintIcon(
                        fn(Get $get): ?string => $get('stock') < 10
                            ? (!$get('stock')
                                ? 'heroicon-m-exclamation-triangle'
                                : 'heroicon-o-exclamation-triangle')
                            : '',
                    )
                    ->hintColor(
                        fn(Get $get): ?string => !$get('stock')
                            ? 'danger'
                            : 'warning',
                    ),
                //
            ])
            ->extraAttributes([
                'class' => 'variation-repeater',
            ])
            ->extraItemActions([
                //
                Action::make('Редактировать')
                    ->icon('heroicon-m-pencil-square')
                    ->action(function (
                        array $arguments,
                        Repeater $component,
                    ): void {
                        $state = $component->getState();
                        $state[$arguments['item']]['is_editing'] = !(
                            $state[$arguments['item']]['is_editing'] ?? false
                        );
                        $component->state($state);
                    }),
            ]);
    }
    private static function detailsSection(): Section
    {
        return Section::make([
            //
            Toggle::make('is_published')->label('Опубликовано'),
            //
            CheckboxList::make('categories')
                ->label('Категории')
                ->relationship(titleAttribute: 'name')
                ->gridDirection('row')
                ->searchable()
                ->searchDebounce(500)
                ->bulkToggleable()
                ->extraAttributes([
                    'style' =>
                        'max-height: 200px !important; overflow-y: scroll !important;',
                    'class' => 'pl-0.5 md:min-w-80',
                ]),
        ]);
    }

    private static function variationPrice(Get $get): int
    {
        return parse_price($get('../../price')) +
            parse_price($get('price_modifier'));
    }
}
