<div class="cart__item cart__table-row">
  {{--  --}}
  <div class="cart__table-cell cart__item-image-cell">
    <div class="cart__item-image">
      <x-main.picture
        class="object-cover"
        :media="$item->product->media->first()"
      />
    </div>
  </div>
  {{--  --}}
  <div class="cart__table-cell cart__item-info-cell">
    <a
      href="{{ route('product', $item->product->slug) }}"
      class="cart__item-name link"
    >
      {{ $item->product->title }}
    </a>
    <div class="cart__item-option">
      {{ $item->variation?->full_title }}
    </div>
  </div>
  {{--  --}}
  <div class="cart__table-cell cart__item-price">
    @if ($item->total_price != $item->price)
      <p class="product__price--old">{{ price_formatter($item->price) }} ₽</p>
    @endif

    <span>{{ price_formatter($item->total_price) }} ₽</span>
  </div>
  <div class="cart__table-cell">
    <div class="cart__item-quantity">
      <div class="product__quantity">
        <div
          x-show="$wire.quantity > 1"
          class="button button-alt product__button product__button--quantity product__button--minus cart__item-quantity--button"
          wire:click.debounce.500ms="set('quantity', $wire.quantity)"
          @click="$wire.quantity--"
        >
          <x-main.icon src="icons/minus.svg" />
        </div>
        <div
          x-show="$wire.quantity <= 1"
          class="button button-alt product__button product__button--quantity product__button--minus cart__item-quantity--button"
          wire:confirm="Удалить товар {{ $item->product->title }} из корзины?"
          wire:click.debounce.300ms="set('quantity', 0)"
        >
          <x-main.icon src="icons/close.svg" />
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
          wire:click.debounce.500ms="set('quantity', $wire.quantity)"
          @click="$wire.quantity++"
        >
          <x-main.icon src="icons/plus.svg" />
        </div>
      </div>
    </div>
  </div>
  {{--  --}}
  <div class="cart__table-cell cart__item-total">
    @if ($item->total_price != $item->price)
      <p class="product__price--old">
        {{ price_formatter($item->price * $quantity) }} ₽
      </p>
    @endif

    <span>{{ price_formatter($item->total_price * $quantity) }} ₽</span>
  </div>
  {{--  --}}
  <div class="cart__table-cell" style="width: 1%; padding-left: 0">
    <span
      class="cart__item-remove link"
      wire:confirm="Удалить товар {{ $item->product->title }} из корзины?"
      wire:click.debounce.300ms="set('quantity', 0)"
    >
      <x-main.icon src="icons/close.svg" />
    </span>
  </div>
</div>
