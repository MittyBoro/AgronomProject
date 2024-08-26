<?php

namespace App\Filament\Resources\CouponResource;

use App\Filament\Forms\BaseForm;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Illuminate\Support\Str;

class CouponForm extends BaseForm
{
    public static function make(Form $form): Form
    {
        $generate = fn() => 'AGRO_' . Str::upper(Str::random(6));

        return $form->columns(1)->schema([
            Section::make()
                ->schema([
                    TextInput::make('code')
                        ->label('Код')
                        ->live()
                        ->default('AGRO_' . Str::upper(Str::random(6)))
                        ->afterStateUpdated(function (
                            Set $set,
                            ?string $state,
                        ): void {
                            $set('code', Str::of($state)->slug('_')->upper());
                        })
                        ->required()
                        ->maxLength(255)
                        ->suffixAction(
                            Action::make('regenerate')
                                ->tooltip('Сгенерировать')
                                ->icon('heroicon-m-arrow-path')
                                ->color('gray')
                                ->action(function (Set $set) use (
                                    $generate,
                                ): void {
                                    $set('code', $generate);
                                }),
                        ),

                    TextInput::make('percentage')
                        ->label('Процент скидки')
                        ->hint('от суммы заказа')
                        ->default(10)
                        ->numeric()
                        ->prefix('%')
                        ->minValue(1)
                        ->maxValue(100)
                        ->required(),

                    TextInput::make('count')
                        ->label('Количество')
                        ->default(1)
                        ->numeric()
                        ->minValue(1)
                        ->required(),

                    Toggle::make('is_active')->label('Активен')->default(true),

                    DateTimePicker::make('expires_at')
                        ->label('Активен до')
                        ->live()
                        ->nullable(true)
                        ->hint(
                            fn($state): ?string => !$state ? 'Бессрочно' : '',
                        )
                        ->minDate(now()),
                ])
                ->maxWidth('3xl'),
        ]);
    }
}
