<?php

namespace App\Filament\Resources\CategoryResource\Forms;

use App\Filament\Forms\BaseForm;
use App\Filament\Forms\MediaUpload;
use App\Filament\Forms\SlugInput;
use App\Filament\Resources\ProductResource;
use App\Models\Category;
use Filament\Actions\Action;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;

class CategoryForm extends BaseForm
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
                self::myInformationSection()->grow(false),
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
                ): void {
                    if (($get('slug') ?? '') !== Str::slug($old)) {
                        return;
                    }

                    $set('slug', Str::slug($state));
                })
                ->required()
                ->maxLength(255),

            SlugInput::make('slug')->prefix('/category/'),

            RichEditor::make('description')
                ->label('Описание')
                ->fileAttachmentsDirectory('attachments/categories')
                ->maxLength(65535),

            MediaUpload::make('media')
                ->label('Изображение')
                ->maxSize(1024 * 20)
                ->image()
                ->imageEditor()
                ->imageResizeMode('cover')
                ->imageCropAspectRatio('1:1')
                ->imageResizeTargetWidth(fn (): ?int => Category::$mediaMaxWidth)
                ->imageResizeTargetHeight(
                    fn (): ?int => Category::$mediaMaxWidth,
                ),
        ];
    }

    private static function myInformationSection(): Section
    {
        return parent::informationSection([
            Placeholder::make('products')
                ->visible(fn (?Category $record): bool => (bool) $record)
                ->label('Товары')
                ->content(
                    fn (?Category $record) => Action::make(
                        $record->products()->count() . ' шт.',
                    )
                        ->icon('heroicon-o-shopping-cart')
                        ->color('gray')
                        ->size('xs')
                        ->url(
                            ProductResource::getUrl('index', [
                                'tableFilters' => [
                                    'categories' => [
                                        'value' => $record->id,
                                    ],
                                ],
                            ]),
                        ),
                ),
        ]);
    }
}
