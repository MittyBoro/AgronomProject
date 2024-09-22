<div>
  {{--  --}}
  <div>
    <h3>Информация о заказе:</h3>
    <div>
      <b>Способ оплаты:</b>
      <span>
        {{
          match ($order->payment_method) {
            'cash' => 'Наличные',
            'yookassa' => 'Банковская карта',
            default => 'Неизвестно',
          }
        }}
      </span>
    </div>

    <div>
      <b>Товары:</b>
      <span>{{ price_formatter($order->price) }} ₽</span>
    </div>

    <div>
      <b>Доставка:</b>
      <span>
        {{ $order->delivery_price ? price_formatter($order->delivery_price) . ' ₽' : 'Бесплатно' }}
      </span>
    </div>

    @if ($order->discount)
      <div>
        <b>Скидка:</b>
        <span>{{ price_formatter($order->discount) }} ₽</span>
      </div>
    @endif

    {{--  --}}
    <div>
      <b>Итого:</b>
      <b>{{ price_formatter($order->total_price) }} ₽</b>
    </div>
  </div>

  {{--  --}}
  <div>
    <h3>Контактное лицо:</h3>
    <div>
      <b>ФИО:</b>
      <span>
        {{ $order->full_name }}
      </span>
    </div>
    <div>
      <b>Телефон:</b>
      <span>
        {{ $order->phone?->formatInternational() }}
      </span>
    </div>
    <div>
      <b>Email:</b>
      <span>
        {{ $order->email }}
      </span>
    </div>
    <div>
      <b>Адрес доставки:</b>
      <div>
        <div>{{ $order->city }}</div>
        <div>{{ $order->address }}</div>
        @if ($order->postal_code)
          <p>Индекс: {{ $order->postal_code }}</p>
        @endif
      </div>
    </div>
  </div>

  {{--  --}}
  @if (! empty($order->delivery_comment))
    <div>
      <h3>Комментарий отправителя:</h3>
      <div>{!! nl2br($order->delivery_comment) !!}</div>
    </div>
  @endif

  {{--  --}}
  <table>
    <tbody>
      @foreach ($order->items as $item)
        <tr>
          <td style="width: 50px; vertical-align: middle; padding: 5px 0">
            <x-main.picture :media="$item->media" />
          </td>
          <td style="padding: 0 10px">
            @if ($item->product)
              <a
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
            @if (! empty($item->variation_title))
              <div>
                {{ $item->variation_title }}
              </div>
            @endif
          </td>
          <td style="text-align: right; white-space: nowrap">
            <div>
              {{ price_formatter(round($item->price)) }} ₽ × {{ $item->quantity }}
            </div>
            <b>
              {{ price_formatter(round($item->price * $item->quantity)) }} ₽
            </b>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
