<?php

namespace App\Filament\Resources\UserResource\Forms;

use App\Models\User;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Support\RawJs;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function form(Form $form): Form
    {
        return $form->columns(1)->schema(self::schema());
    }

    private static function schema(): array
    {
        return [
            Tabs::make('settings')
                ->id('user-tabs')
                ->tabs([
                    Tabs\Tab::make('main')
                        ->label('Основное')
                        ->schema(self::mainTabSchema()),
                    Tabs\Tab::make('password')
                        ->label('Пароль')
                        ->schema(self::passwordTabSchema()),
                ]),
        ];
    }

    private static function mainTabSchema(): array
    {
        return [
            //
            TextInput::make('name')
                ->helperText('Имя пользователя, например в отзывах')
                ->label('Отображаемое имя')
                ->minLength(1)
                ->maxLength(255)
                ->required(),
            //
            Grid::make()
                ->columns([
                    'default' => 1,
                    'xl' => 3,
                ])
                ->schema([
                    TextInput::make('last_name')
                        ->label('Фамилия')
                        ->maxLength(255),
                    TextInput::make('first_name')->label('Имя')->maxLength(255),
                    TextInput::make('middle_name')
                        ->label('Отчество')
                        ->maxLength(255),
                ]),

            //
            Grid::make()
                ->columns([
                    'default' => 1,
                    'xl' => 2,
                ])
                ->schema([
                    DatePicker::make('birthday')
                        ->label('Дата рождения')
                        ->native(false)
                        ->displayFormat('d F Y')
                        ->minDate(now()->subYears(150))
                        ->maxDate(now()->subYears(5))
                        ->locale('ru'),
                    Select::make('gender')
                        ->label('Пол')
                        ->options([
                            null => 'Не указан',
                            User::GENDER_MALE => 'Мужской',
                            User::GENDER_FEMALE => 'Женский',
                        ])
                        ->native(false),
                ]),

            //
            Grid::make()
                ->columns([
                    'default' => 1,
                    'xl' => 2,
                ])
                ->schema([
                    TextInput::make('email')
                        ->label('E-mail')
                        ->email()
                        ->minLength(1)
                        ->maxLength(255)
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->suffixActions([
                            // Other actions here
                            Action::make('verifyEmail')
                                ->label('Верифицировать email')
                                ->icon('heroicon-m-check-circle')
                                ->tooltip('Верифицировать email')
                                ->color('warning')
                                ->requiresConfirmation()
                                ->action(function (User $record) {
                                    $record->email_verified_at = now();
                                    $record->save();
                                })
                                ->visible(
                                    fn($record) => !$record->email_verified_at,
                                ),
                        ]),

                    //
                    TextInput::make('phone')
                        ->label('Телефон')
                        ->tel()
                        ->mask(
                            RawJs::make(
                                <<<'JS'
                                    '+7 999 999 99 99'
                                JS
                                ,
                            ),
                        )
                        ->formatStateUsing(
                            fn(string $state): string => phone(
                                $state,
                                'ru',
                            )->formatE164(),
                        )
                        ->rules('phone:INTERNATIONAL:ru'),
                ]),
        ];
    }

    private static function passwordTabSchema(): array
    {
        return [
            TextInput::make('password')
                ->label('Новый пароль')
                ->password()
                ->minLength(8)
                ->maxLength(255)
                ->password()
                ->dehydrateStateUsing(fn($state) => Hash::make($state))
                ->dehydrated(fn($state) => filled($state))
                ->confirmed()
                ->revealable(true)
                ->disabled(fn($record) => $record && $record->is_admin),
            TextInput::make('password_confirmation')
                ->label('Повторите новый пароль')
                ->password()
                ->minLength(8)
                ->maxLength(255)
                ->revealable(true)
                ->disabled(fn($record) => $record && $record->is_admin),
        ];
    }
}
