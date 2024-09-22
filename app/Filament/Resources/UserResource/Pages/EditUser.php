<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Filament\Traits\EditRecordPage;
use App\Models\User;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EditUser extends EditRecord
{
    use EditRecordPage;

    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('change_password')
                ->label('Изменить пароль')
                ->visible(fn(User $record) => $record->id === Auth::id())
                ->modalHeading(
                    fn(User $record) => 'Комментарий к заказу #' . $record->id,
                )
                ->modalDescription(
                    'Здесь можно оставить код для отслеживания заказа, или другие данные, которые увидит покупатель',
                )
                ->form([
                    TextInput::make('password')
                        ->label('Пароль')
                        ->password()
                        ->minLength(8)
                        ->maxLength(255)
                        ->confirmed()
                        ->password()
                        ->confirmed()
                        ->revealable(true),
                    TextInput::make('password_confirmation')
                        ->label('Повторите пароль')
                        ->password()
                        ->minLength(8)
                        ->maxLength(255)
                        ->revealable(true),
                ])
                ->action(function (array $data, User $record): void {
                    $record->password = Hash::make($data['password']);
                    $record->save();
                }),
        ];
    }
}
