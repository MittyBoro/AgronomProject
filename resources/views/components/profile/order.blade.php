<div class="profile-order" x-data="{ open: {{ $open ?? 'false' }} }">
  <div class="profile-order__header" @click="open = ! open">
    <div class="profile-order__number">Заказ #{{ $order->id }}</div>
    <div class="profile-order__date">
      {{ $order->created_at->format('d.m.Y в H:i') }}
    </div>
    <div class="profile-order__status">
      <span
        class="profile-order__status-icon profile-order__status--{{
          match ($order->status->value) {
            'completed' => 'success',
            'processing', 'shipped' => 'info',
            'refunded' => '',
            default => 'pending',
          }
        }}"
      ></span>
      <span>{{ $order->status->label() }}</span>
    </div>
    <x-main.icon
      class="profile-order__arrow"
      src="icons/arrow-simple.svg"
      ::class="{ 'active': open }"
    />
  </div>
  <div class="profile-order__body" x-cloak x-show="open" x-collapse>
    <div class="profile-order__info">
      <div class="profile-order__info-header">Информация о заказе</div>
      <div class="profile-order__info-line profile__info-line">
        <div class="profile-order__info-title profile__info-title">
          Способ оплаты
        </div>
        <div class="profile-order__info-text profile__info-text">
          {{
            match ($order->payment_method) {
              'cash' => 'Наличные',
              'yookassa' => 'Банковская карта',
            }
          }}
        </div>
      </div>

      <div class="profile-order__info-line profile__info-line">
        <div class="profile-order__info-title profile__info-title">Товары</div>
        <div class="profile-order__info-text profile__info-text">
          {{ price_formatter($order->price) }} ₽
        </div>
      </div>

      <div class="profile-order__info-line profile__info-line">
        <div class="profile-order__info-title profile__info-title">
          Стоимость доставки
        </div>
        <div class="profile-order__info-text profile__info-text">
          {{ $order->delivery_price ? price_formatter($order->delivery_price) . ' ₽' : 'Бесплатно' }}
        </div>
      </div>

      @if ($order->discount)
        <div class="profile-order__info-line profile__info-line">
          <div class="profile-order__info-title profile__info-title">
            Скидка
          </div>
          <div class="profile-order__info-text profile__info-text">
            {{ price_formatter($order->discount) }} ₽
          </div>
        </div>
      @endif

      {{--  --}}
      @if ($order->earned_amount)
        <div class="profile-order__info-line profile__info-line">
          <div class="profile-order__info-title profile__info-title">
            Начально бонусов
          </div>
          <div class="profile-order__info-text profile__info-text primary">
            <b>{{ $order->earned_amount }}</b>
          </div>
        </div>
      @endif

      {{--  --}}
      <div class="profile-order__info-line profile__info-line">
        <div class="profile-order__info-title profile__info-title">Итого</div>
        <div class="profile-order__info-text profile__info-text">
          <b>{{ price_formatter($order->total_price) }} ₽</b>
        </div>
      </div>
    </div>
    <div class="profile-order__info">
      <div class="profile-order__info-header">Контактное лицо</div>
      <div class="profile-order__info-line profile__info-line">
        <div class="profile-order__info-title profile__info-title">
          Контактное лицо
        </div>
        <div class="profile-order__info-text profile__info-text">
          {{ $order->full_name }}
        </div>
      </div>
      <div class="profile-order__info-line profile__info-line">
        <div class="profile-order__info-title profile__info-title">Телефон</div>
        <div class="profile-order__info-text profile__info-text">
          {{ $order->phone?->formatInternational() }}
        </div>
      </div>
      <div class="profile-order__info-line profile__info-line">
        <div class="profile-order__info-title profile__info-title">Email:</div>
        <div class="profile-order__info-text profile__info-text">
          {{ $order->email }}
        </div>
      </div>
      <div class="profile-order__info-line profile__info-line">
        <div class="profile-order__info-title profile__info-title">
          Адрес доставки
        </div>
        <div class="profile-order__info-text profile__info-text">
          <p>{{ $order->city }}</p>
          <p>{{ $order->address }}</p>
          @if ($order->postal_code)
            <p>Индекс: {{ $order->postal_code }}</p>
          @endif
        </div>
      </div>
    </div>
    <div class="profile-order__products">
      @foreach ($order->items as $item)
        <div class="profile-order__product">
          <div class="profile-order__product-image cart__item-image">
            <x-main.picture class="object-cover" :media="$item->media" />
          </div>
          <div class="profile-order__product-name">
            @if ($item->product)
              <a
                class="link"
                href="{{ route('product', $item->product->slug) }}"
                target="_blank"
              >
                {{ $item->product_title }}
              </a>
            @else
              <span>
                {{ $item->product_title }}
              </span>
            @endif
            <div class="profile-order__product-option gray">
              {{ $item->variation_title }}
            </div>
          </div>
          <div class="profile-order__product-price">
            <span>{{ price_formatter(round($item->price)) }} ₽</span>
            <span>× {{ $item->quantity }}</span>
          </div>
          <div class="profile-order__product-total">
            <b>
              {{ price_formatter(round($item->price * $item->quantity)) }} ₽
            </b>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
