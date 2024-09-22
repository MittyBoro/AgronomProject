<?php

namespace App\Filament\Resources\ReviewResource;

use App\Filament\Forms\BaseForm;
use App\Filament\Forms\MediaUpload;
use App\Filament\Resources\ProductResource;
use App\Filament\Resources\UserResource;
use App\Models\Review;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Illuminate\Support\HtmlString;

class ReviewForm extends BaseForm
{
    public static function make(Form $form): Form
    {
        return $form->columns(1)->schema([
            Split::make([
                Section::make()->schema([
                    //
                    Select::make('product_id')
                        ->relationship('product', 'title')
                        ->searchable(['title', 'description'])
                        ->preload()
                        ->label('Товар'),

                    TextInput::make('name')
                        ->label('Имя автора')
                        ->required()
                        ->maxLength(255),

                    Select::make('rating')
                        ->label('Рейтинг')
                        ->prefixIcon('heroicon-o-star')
                        ->required()
                        ->options([
                            '1' => '1 звезда',
                            '2' => '2 звезды',
                            '3' => '3 звезды',
                            '4' => '4 звезды',
                            '5' => '5 звёзд',
                        ]),
                    //

                    //
                    RichEditor::make('comment')
                        ->label('Отзыв')
                        ->required()
                        ->maxLength(65535),

                    // MediaUpload::make('media')
                    //     ->label('Изображения')
                    //     ->multiple()
                    //     ->maxFiles(10)
                    //     ->maxSize(1024 * 20)
                    //     ->image()
                    //     ->imageEditor()
                    //     ->imageResizeTargetWidth(
                    //         fn(): ?int => Review::$mediaMaxWidth,
                    //     )
                    //     ->imageResizeTargetHeight(
                    //         fn(): ?int => Review::$mediaMaxWidth,
                    //     ),
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
            Placeholder::make('user')
                ->label('Автор отзыва')
                ->hidden(fn(?Review $record) => !$record?->user)
                ->content(
                    fn(?Review $record) => new HtmlString(
                        '<a class="text-primary-500" href="' .
                            UserResource::getUrl('edit', [
                                'record' => $record->user,
                            ]) .
                            '">' .
                            $record->user->name .
                            '</a>',
                    ),
                ),
            Placeholder::make('product')
                ->label('Товар')
                ->hidden(fn(?Review $record) => !$record?->product)
                ->content(
                    fn(?Review $record) => new HtmlString(
                        '<a class="block text-primary-500 max-w-60 truncate" href="' .
                            ProductResource::getUrl('edit', [
                                'record' => $record->product,
                            ]) .
                            '">' .
                            $record->product->title .
                            '</a>',
                    ),
                ),

            Toggle::make('is_approved')->default(true)->label('Одобрено'),
            Toggle::make('is_pinned')->label('Закреплено'),
        ];
    }
}
