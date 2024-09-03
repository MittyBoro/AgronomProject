<?php

namespace App\Livewire;

use App\Livewire\Forms\CheckoutForm;
use App\Models\Coupon;
use App\Models\User;
use App\Services\Cart\CartService;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Session;
use Livewire\Component;

class CheckoutPage extends Component
{
    use SEOToolsTrait;

    public array $breadcrumbs = [
        ['/cart', 'Корзина'],
        ['', 'Оформление заказа'],
    ];

    public CheckoutForm $form;

    private CartService $cartService;

    private User $user;

    public ?int $subTotal = 0;

    public bool $isEarnBonuses = true;

    public ?int $spentBonuses = 0;

    #[Session]
    public ?string $couponStr;

    public ?string $couponError;

    public ?Coupon $coupon;

    public ?int $couponAmount = 0;

    private $maxSpentPercent = 30;

    public function boot(CartService $cartService): void
    {
        $this->cartService = $cartService;
        $this->user = Auth::user();
    }

    public function mount(): void
    {
        $this->setDataByCart();

        $this->fillFormDefaults();

        $this->seo()->setTitle('Оформление заказа');
        $this->seo()->metatags()->addMeta('robots', 'noindex, nofollow');
    }

    #[Computed]
    public function items()
    {
        return $this->cartService->items(full: true);
    }

    #[Computed]
    public function total(): int
    {
        return $this->subTotal - $this->couponAmount - $this->spentBonuses;
    }

    #[Computed]
    public function earnBonuses(): int
    {
        return floor($this->total * $this->user->loyalty?->percentage) / 100;
    }

    #[Computed]
    public function maxSpentBonuses(): int
    {
        // можно списать до {$maxSpentPercent}% из общей суммы
        $maxSpentBonusesByCart = round(
            (($this->subTotal - $this->couponAmount) * $this->maxSpentPercent) /
                100,
        );
        $maxSpentBonuses = max(
            0,
            min($maxSpentBonusesByCart, $this->user->balance),
        );

        return $maxSpentBonuses ?? 0;
    }

    /**
     * Заполняем значения из корзины
     */
    public function setDataByCart()
    {
        if ($this->cartService->count() === 0) {
            return $this->redirectToCart(
                'Корзина пуста, оформление заказа невозможно',
            );
        }

        // проверка после получения продуктов, что бы не делать несколько запросов
        if ($this->cartService->checkStock()) {
            return $this->redirectToCart(
                'Состав корзины изменен, ознакомьтесь с обновлёнными данными',
            );
        }

        // рассчёт общей суммы
        $this->subTotal = $this->cartService->totalPrice();

        // применить промокод, если был введён ранее
        if ($this->couponStr) {
            $this->applyCoupon();
        }
    }

    private function redirectToCart(string $error): void
    {
        add_session_error($error);
        $this->redirect('/cart');
    }

    /**
     * Заполнить форму по умолчанию из старого заказа
     * или по данными пользователя
     */
    private function fillFormDefaults(): void
    {
        $oldOrder = $this->user
            ->orders()
            ->where('save_info', 1)
            ->latest()
            ->first();

        if ($oldOrder) {
            $this->form->fill(
                Arr::only($oldOrder->toArray(), [
                    'full_name',
                    'email',
                    'phone',
                    'postal_code',
                    'city',
                    'address',
                ]),
            );
        } else {
            if (
                !$this->form->full_name &&
                isset(
                    $this->user->first_name,
                    $this->user->last_name,
                    $this->user->middle_name,
                )
            ) {
                $this->form->full_name = implode(' ', [
                    $this->user->first_name,
                    $this->user->middle_name,
                    $this->user->last_name,
                ]);
            }
            if (!$this->form->phone) {
                $this->form->phone = $this->user->phone;
            }
            if (!$this->form->email) {
                $this->form->email = $this->user->email;
            }
        }
    }

    /**
     * Применить купон
     */
    public function applyCoupon(): void
    {
        // сбросить скидку бонусами
        $this->spentBonuses = 0;
        $this->isEarnBonuses = true;

        if (empty($this->couponStr)) {
            $this->couponError = '';
            $this->couponAmount = 0;
            $this->coupon = null;

            return;
        }

        $code = Str::upper($this->couponStr);
        $this->coupon = Coupon::where('code', $code)->isActive()->first();

        if (!$this->coupon) {
            $this->couponError = 'Купон не найден или недействителен';
        } else {
            $this->couponError = null;
            $this->couponAmount = round(
                ($this->subTotal * $this->coupon->percentage) / 100,
            );
        }
    }

    public function submit(): void
    {
        //
    }
}
