<?php

namespace App\Livewire;

use App\Livewire\Forms\CheckoutForm;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Prop;
use App\Models\User;
use App\Services\Cart\CartService;
use App\Services\Payment\PaymentService;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Exception;
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

    public ?int $subTotal = 0; // сумма всех позиций в корзине

    public bool $isEarnBonuses = true; // начислить (true) или списать (false) бонусы

    public ?int $spentBonuses = 0; // потратить бонусы

    #[Session]
    public ?string $couponCode = null; // код купона

    public ?string $couponError; // ошибка при применении купона

    private ?Coupon $coupon = null; // купон

    public ?int $couponAmount = 0; // скидка по купону

    public function boot(CartService $cartService): void
    {
        $this->cartService = $cartService;
        $this->user = Auth::user();
    }

    public function mount(): void
    {
        $this->fillFormDefaults();

        $this->seo()->setTitle('Оформление заказа');
        $this->seo()->metatags()->addMeta('robots', 'noindex, nofollow');

        $this->setDataByCart();

        // применить промокод, если был введён ранее
        if ($this->couponCode) {
            $this->applyCoupon();
        }
    }

    /**
     * Список позиций в корзине
     */
    #[Computed]
    public function items()
    {
        return $this->cartService->items(full: true);
    }

    /**
     * Стоимость доставки
     */
    #[Computed]
    public function delivery(): int
    {
        $freeDeliveryMinAmount = (int) Prop::get('free_delivery_min_amount', 0);

        if (
            $this->subTotal - $this->couponAmount - $this->spentBonuses >=
            $freeDeliveryMinAmount
        ) {
            return 0;
        }

        return (int) Prop::get('delivery_price', 0);
    }

    /**
     * Итоговая стоимость со скидками
     */
    #[Computed]
    public function total(): int
    {
        return $this->subTotal -
            $this->couponAmount -
            $this->spentBonuses +
            $this->delivery();
    }

    /**
     * Сколько начислим бонусов
     */
    #[Computed]
    public function earnBonuses(): int
    {
        return floor($this->total * $this->user->loyalty?->percent) / 100;
    }

    /**
     * Сколько можно списать бонусов
     */
    #[Computed]
    public function maxSpentBonuses(): int
    {
        // можно списать до {$maxSpentPercent}% из общей суммы
        $maxSpentPercent = Prop::get('max_bonuses_spend_percent', 10);

        $maxSpentBonusesByCart = round(
            (($this->subTotal - $this->couponAmount + $this->delivery()) *
                $maxSpentPercent) /
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
    }

    /**
     * Перенаправление на страницу корзины в случае ошибки
     */
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

        $this->form->payment_method =
            array_keys(config('shop.drivers'))[0] ?? null;
    }

    /**
     * Применить купон
     */
    public function applyCoupon($resetSpentBonuses = true): void
    {
        // сбросить скидку бонусами
        if ($resetSpentBonuses) {
            $this->spentBonuses = 0;
            $this->isEarnBonuses = true;
        }

        if (empty($this->couponCode)) {
            $this->couponError = '';
            $this->couponAmount = 0;
            $this->coupon = null;

            return;
        }

        $code = Str::upper($this->couponCode);
        $this->coupon = Coupon::where('code', $code)->isActive()->first();

        if (!$this->coupon) {
            $this->couponError = 'Купон не найден или недействителен';
        } else {
            $this->couponError = null;
            $this->couponAmount = round(
                (($this->subTotal + $this->delivery()) *
                    $this->coupon->percent) /
                    100,
            );
        }
    }

    /**
     * Отправить форму
     */
    public function submit(): void
    {
        // заполнить информацию из корзины
        $this->setDataByCart();
        // применить промокод, если введён
        if ($this->couponCode) {
            $this->applyCoupon(false);
        }

        $this->validate();

        $data = $this->form->all();

        $data['user_id'] = $this->user->id;

        $data['price'] = $this->subTotal;
        $data['delivery_price'] = $this->delivery();
        $data['total_price'] = $this->total();

        if ($this->coupon) {
            $data['coupon_id'] = $this->coupon->id;
        }

        $discountFactor =
            ($data['total_price'] - $data['delivery_price']) / $data['price'];

        $items = $this->getOrderItems($discountFactor);

        // создать заказ
        $order = Order::create($data);
        $order->items()->createMany($items);

        // потратить бонусы

        if ($this->spentBonuses) {
            $order->bonuses()->create([
                'amount' => $this->spentBonuses * -1,
                'user_id' => $this->user->id,
            ]);
        }

        try {
            $payment = PaymentService::set($order);
            $payment->charge();

            $order->refresh();

            // удалить купон
            $this->couponCode = null;

            // перенаправить на страницу оплаты
            $this->redirect($order->getPaymentUrl());
        } catch (Exception $e) {
            $order->delete();
            $this->addError('payment', $e->getMessage());
        }
    }

    /**
     * Получить список товаров для заказа
     * с учётом полной скидки на сумму заказа
     */
    private function getOrderItems(float $discountFactor): array
    {
        $items = [];
        foreach ($this->items() as $item) {
            $items[] = [
                'product_id' => $item->product_id,
                'product_variation_id' => $item->product_variation_id,
                'media_id' => $item->product->media()->first()?->id,
                'product_title' => $item->product->title,
                'variation_title' => $item->variation?->full_title,
                'quantity' => $item->quantity,
                'price' => $item->total_price * $discountFactor,
            ];
        }

        return $items;
    }
}
