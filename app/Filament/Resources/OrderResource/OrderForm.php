<?php

namespace App\Filament\Resources\OrderResource;

use App\Filament\Forms\BaseForm;
use App\Filament\Resources\ProductResource;
use App\Models\Category;
use Filament\Actions\Action;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

class OrderForm extends BaseForm
{
    public static function make(Form $form): Form
    {
        // 'title',
        // 'description',
        // 'percentage',
        // 'min_order_sum',
        return $form->columns(1)->schema([
            Split::make([
                Section::make()->schema([
                    //
                    TextInput::make('title')
                        ->label('Название')
                        ->required()
                        ->maxLength(255),
                    //
                    Textarea::make('description')
                        ->label('Описание')
                        ->rows(3)
                        ->autosize()
                        ->maxLength(2048),
                    //
                    TextInput::make('percentage')
                        ->label('Начисляемый процент')
                        ->hint('от суммы заказа')
                        ->numeric()
                        ->prefix('%')
                        ->minValue(1)
                        ->maxValue(100)
                        ->required(),
                    //
                    TextInput::make('min_order_sum')
                        ->label('Минимальная сумма заказов')
                        ->hint('для достижения уровня')
                        ->numeric()
                        ->prefix('₽')
                        ->minValue(0)
                        ->maxValue(100)
                        ->required(),
                ]),

                // сайдбар справа
                self::informationSection(
                    self::informationSectionComponents(),
                )->grow(false),
            ])->from('xl'),
        ]);
    }

    private static function informationSectionComponents(): array
    {
        return [
                // Placeholder::make('products')
                //     ->visible(fn(?Category $record): bool => (bool) $record)
                //     ->label('Товары')
                //     ->content(
                //         fn(?Category $record) => Action::make(
                //             $record->products()->count() . ' шт.',
                //         )
                //             ->icon('heroicon-o-shopping-cart')
                //             ->color('gray')
                //             ->size('xs')
                //             ->url(
                //                 ProductResource::getUrl('index', [
                //                     'tableFilters' => [
                //                         'categories' => [
                //                             'value' => $record->id,
                //                         ],
                //                     ],
                //                 ]),
                //             ),
                //     ),
            ];
    }
}
