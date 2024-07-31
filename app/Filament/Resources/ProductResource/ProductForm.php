<?php

namespace App\Filament\Resources\ProductResource;

use App\Filament\Forms\BaseForm;
use App\Filament\Forms\MediaUpload;
use App\Filament\Forms\SlugInput;
use App\Filament\Resources\ReviewResource;
use App\Models\Product;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
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
                            ->schema(static::mainTabSchema()),
                        //
                        Tabs\Tab::make('price')
                            ->label('Цена')
                            ->schema(ProductFormTabPrice::schema()),
                        //
                        Tabs\Tab::make('seo')
                            ->label('SEO')
                            ->schema(static::seoSchema()),
                    ]),
                //
                Grid::make(['default' => '1'])
                    ->schema([
                        static::detailsSection(),
                        static::informationSection(
                            self::informationSectionComponents(),
                        ),
                    ])
                    ->extraAttributes([
                        'class' => 'xl:max-w-md',
                    ])
                    ->grow(false),
            ])->from('xl'),
        ]);
    }

    /**
     * Основные данные по товару:
     * Название, Слаг, Описание, Изображения
     */
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

            SlugInput::make('slug')->prefix('/product/'),

            RichEditor::make('description')
                ->label('Описание')
                ->fileAttachmentsDirectory('attachments/products')
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
                ->imageResizeTargetWidth(fn (): ?int => Product::$mediaMaxWidth)
                ->imageResizeTargetHeight(
                    fn (): ?int => Product::$mediaMaxWidth,
                ),
        ];
    }

    /**
     * Цены:
     * Базовая цена, Остаток на складе, вариации
     */

    /**
     * Вариации:
     * Цена, Остаток на складе, Имя вариации
     */
    private static function detailsSection(): Section
    {
        return Section::make([
            //
            Toggle::make('is_published')->label('Опубликовано'),
            //
            CheckboxList::make('categories')
                ->label('Категории')
                ->relationship('categories', titleAttribute: 'title')
                ->gridDirection('row')
                ->searchable()
                ->searchDebounce(500)
                ->bulkToggleable()
                ->extraAttributes([
                    'style' => 'max-height: 200px !important; overflow-y: scroll !important;',
                    'class' => 'pl-0.5 md:min-w-80',
                ]),
        ]);
    }

    private static function informationSectionComponents(): array
    {
        return [
            Actions::make([
                Action::make('reviews')
                    ->badge()
                    ->icon('heroicon-o-star')
                    ->color('success')
                    ->label(
                        fn (?Product $record) => round(
                            $record->reviews()->avg('rating'),
                            2,
                        ) . " ({$record->reviews()->count()} отзывов)",
                    )
                    ->url(
                        fn (?Product $record) => ReviewResource::getUrl(
                            'index',
                            [
                                'tableFilters' => [
                                    'products' => [
                                        'value' => $record->id,
                                    ],
                                ],
                            ],
                        ),
                    ),
            ])
                ->hidden(
                    fn (?Product $record) => ! $record ||
                        $record->reviews()->count() === 0,
                ),
        ];
    }
}
