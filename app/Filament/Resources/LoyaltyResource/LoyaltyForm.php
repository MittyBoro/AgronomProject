<?php

namespace App\Filament\Resources\LoyaltyResource;

use App\Filament\Forms\BaseForm;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

class LoyaltyForm extends BaseForm
{
    public static function make(Form $form): Form
    {
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
                    TextInput::make('percent')
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
                //
            ];
    }
}
