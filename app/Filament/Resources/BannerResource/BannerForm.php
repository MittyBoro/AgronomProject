<?php

namespace App\Filament\Resources\BannerResource;

use App\Filament\Forms\BaseForm;
use App\Filament\Forms\MediaUpload;
use App\Models\Banner;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Illuminate\Support\Carbon;

class BannerForm extends BaseForm
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
                    TextInput::make('url')
                        ->label('Ссылка')
                        ->url()
                        ->maxLength(255)
                        ->suffixAction(
                            Action::make('set_default')
                                ->tooltip('Поставить по умолчанию')
                                ->icon('heroicon-m-cube-transparent')
                                ->color('gray')
                                ->action(function (Set $set, $state): void {
                                    $set('url', config('app.url') . '/catalog');
                                }),
                        ),

                    //
                    DateTimePicker::make('expires_at')
                        ->label('Опубликовано до')
                        ->live()
                        ->helperText(
                            fn($state): string => Carbon::parse(
                                $state,
                            )?->diffForHumans(),
                        )
                        ->hintAction(
                            Action::make('set_default')
                                ->label('+ 1 день')
                                ->color('gray')
                                ->action(function (Set $set, $state): void {
                                    $set(
                                        'expires_at',
                                        Carbon::parse($state)
                                            ->addDay()
                                            ->format('Y-m-d H:i:s'),
                                    );
                                }),
                        )
                        ->maxDate(now()->addYears(150))
                        ->minDate(now()),

                    //
                    MediaUpload::make('media')
                        ->label('Изображение')
                        ->maxSize(1024 * 20)
                        ->image()
                        ->imageEditor()
                        ->imageResizeTargetWidth(
                            fn(): ?int => Banner::$mediaMaxWidth,
                        )
                        ->imageResizeTargetHeight(
                            fn(): ?int => Banner::$mediaMaxWidth,
                        ),
                ]),
                self::informationSection([
                    Toggle::make('is_published')->label('Активно'),
                ])->grow(false),
            ])->from('xl'),
        ]);
    }

    private static function mainTabSchema(): array
    {
        return [];
    }
}
