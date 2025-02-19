<?php

namespace App\Filament\Resources\UserResource;

use App\Enums\GenderEnum;
use App\Enums\RoleEnum;
use App\Models\User;
use Closure;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Support\RawJs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function make(Form $form): Form
    {
        return $form->columns(1)->schema(self::mainDataSchema());
    }

    private static function mainDataSchema(): array
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
                        ->options(GenderEnum::array())
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
                        ->label('Email')
                        ->email()
                        ->minLength(1)
                        ->maxLength(255)
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->suffixActions([
                            // Other actions here
                            Action::make('verifyEmail')
                                ->label('Верифицировать email')
                                ->icon('heroicon-m-exclamation-circle')
                                ->tooltip('Верифицировать email')
                                ->color('warning')
                                ->requiresConfirmation()

                                ->action(function (User $record): void {
                                    $record->email_verified_at = now();
                                    $record->save();
                                })
                                ->hidden(fn($record) => !$record)
                                ->visible(
                                    fn($record) => !$record?->email_verified_at,
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
                            fn(?string $state): string => $state
                                ? phone($state, 'ru')->formatE164()
                                : '',
                        )
                        ->rules('phone:INTERNATIONAL:ru'),
                ]),

            Toggle::make('is_notifiable')->label('Получать уведомления'),

            Select::make('role')
                ->label('Роль')
                ->options(RoleEnum::array())
                ->default(RoleEnum::User)
                ->required()
                ->native(false)
                ->rules([
                    fn(Get $get): Closure => function (
                        string $attribute,
                        $value,
                        Closure $fail,
                    ) use ($get): void {
                        if ($get('id') === 1) {
                            if (Auth::id() !== 1) {
                                $fail(
                                    'Редактирование администратора запрещено.',
                                );
                            }
                            if ($value !== RoleEnum::Admin->value) {
                                $fail('Роль должна быть администратором.');
                            }
                        }
                    },
                ]),

            ...self::passwordTabSchema(),
        ];
    }

    private static function passwordTabSchema(): array
    {
        return [
            TextInput::make('password')
                ->label('Пароль')
                ->password()
                ->minLength(8)
                ->maxLength(255)
                ->confirmed()
                ->password()
                ->dehydrateStateUsing(fn($state) => Hash::make($state))
                ->dehydrated(fn($state) => filled($state))
                ->afterStateHydrated(function (
                    TextInput $component,
                    $state,
                ): void {
                    $component->state('');
                })
                ->confirmed()
                ->revealable(true)
                ->hidden(fn(?User $record) => $record),
            TextInput::make('password_confirmation')
                ->label('Повторите пароль')
                ->password()
                ->confirmed()
                ->minLength(8)
                ->maxLength(255)
                ->revealable(true)
                ->hidden(fn(?User $record) => $record),
        ];
    }
}
