<div class="cart__item cart__table-row">
  {{--  --}}
  <div class="cart__table-cell cart__item-image-cell">
    <div class="cart__item-image">
      <img
        class="object-cover"
        src="{{ Vite::front('images/product-demo.png') }}"
        alt="Название товара"
      />
    </div>
  </div>
  {{--  --}}
  <div class="cart__table-cell cart__item-info-cell">
    <div class="cart__item-name">
      {{ $item->product->title }}
    </div>
    <div class="cart__item-option">
      {{ $item->variations->pluck('full_title')->join(', ') }}
    </div>
  </div>
  {{--  --}}
  <div class="cart__table-cell cart__item-price">
    @if ($item->total_price != $item->price)
      <p class="product__price--old">{{ price_formatter($item->price) }}₽</p>
    @endif

    <span>{{ price_formatter($item->total_price) }}₽</span>
  </div>
  <div class="cart__table-cell">
    <div class="cart__item-quantity">
      <div class="product__quantity">
        <div
          class="button button-alt product__button product__button--quantity product__button--minus cart__item-quantity--button"
          @click="$wire.set('quantity', --$wire.quantity)"
        >
          <x-main.icon src="icons/minus.svg" />
        </div>
        <input
          class="button button-input product__button product__button--quantity product__button--input cart__item-quantity--button"
          type="number"
          min="1"
          max="99"
          wire:model.change="quantity"
        />
        <div
          class="button button-alt product__button--quantity product__button--plus cart__item-quantity--button"
          @click="$wire.set('quantity', ++$wire.quantity)"
        >
          <x-main.icon src="icons/plus.svg" />
        </div>
      </div>
    </div>
  </div>
  {{--  --}}
  <div class="cart__table-cell cart__item-total">
    <span>{{ price_formatter($item->price * $quantity) }}₽</span>
  </div>
</div>
