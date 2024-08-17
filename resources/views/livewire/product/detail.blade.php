<div class="product__details">
  {{-- title --}}
  <div class="product__title">
    <h1>{{ $product['title'] }}</h1>
  </div>

  {{-- rating and availability --}}
  <div class="product__rating rating">
    <div
      class="product__rating--stars rating__stars"
      style="--percent: {{ ($product['reviews_avg_rating'] / 5) * 100 }}%"
    ></div>
    @if ($product['reviews_count'])
      <a class="product__rating--count rating__count" href="#reviews">
        ({{ $product['reviews_count'] }})
      </a>
    @endif

    <div class="product__rating-separator">|</div>
    <div
      @class([
        'product__availability',
        match (true) {
          ! $this->stock => 'red',
          $this->stock < 10 => 'yellow',
          default => 'green',
        },
      ])
    >
      {{
        match (true) {
          ! $this->stock => 'Нет в наличии',
          $this->stock < 10 => 'Скоро закончится',
          default => 'В наличии',
        }
      }}
    </div>
  </div>

  {{-- price --}}
  <div class="product__price" wire:loading.class="loading">
    <span>{{ price_formatter($this->total_price) }}₽</span>
    @if ($this->total_price !== $this->price)
      <span class="product__price--old">
        {{ price_formatter($this->price) }}₽
      </span>
      <span class="products__badge">-{{ (float) $product['discount'] }}%</span>
    @endif
  </div>

  {{-- description --}}
  <div class="product__description prose" wire:loading.class="loading">
    {{ $product['description'] }}
  </div>

  <div class="product__details-separator"></div>
  {{-- options --}}
  <div class="product__variation--groups" wire:loading.class="loading">
    @foreach ($product['grouped_variations'] as $group)
      <div class="product__variation">
        <div class="button button-alt product__variation--title">
          {{ $group['title'] }}
          <span></span>
          :
        </div>
        <div class="product__variation-buttons">
          @foreach ($group['variations'] as $variation)
            <label class="product__variation--label">
              <input
                class="product__variation-input"
                name="variation"
                type="radio"
                value="{{ $variation['id'] }}"
                wire:model.change="activeVariationId"
              />
              <div class="button button-alt product__variation--button">
                {{ $variation['title'] }}
              </div>
            </label>
          @endforeach
        </div>
      </div>
    @endforeach
  </div>

  {{-- actions --}}
  <div class="product__actions" wire:loading.class="loading">
    {{-- quantity --}}
    <div class="product__quantity">
      <div
        class="button button-alt product__button product__button--quantity product__button--minus"
        @click="$wire.set('quantity', --$wire.quantity)"
      >
        <x-main.icon src="icons/minus.svg" />
      </div>
      <input
        class="button button-input product__button product__button--quantity product__button--input"
        type="number"
        wire:model.number="quantity"
        min="1"
        :max="$wire.get('stock')"
      />
      <div
        class="button button-alt product__button--quantity product__button--plus"
        @click="$wire.set('quantity', ++$wire.quantity)"
      >
        <x-main.icon src="icons/plus.svg" />
      </div>
    </div>
    {{-- to cart --}}
    @if (! $inCart)
      <button
        wire:click="addToCart"
        class="button product__button product__button--cart"
      >
        В корзину
      </button>
    @else
      <a
        href="/cart"
        wire:navigate
        class="button button-alt product__button product__button--cart"
      >
        В корзине
      </a>
    @endif

    {{-- to wishlist --}}
    <button class="button button-alt product__button product__button--favorite">
      <x-main.icon src="icons/heart.svg" />
    </button>
  </div>

  {{-- delivery --}}
  <div class="product__delivery">
    <x-main.icon class="product__sipping-icon" src="icons/delivery.svg" />
    <div class="product__sipping-text">
      <div class="product__sipping-title">Бесплатная доставка</div>
      <a class="link underline" href="#">Доставляем товары по всей России</a>
    </div>
  </div>
</div>
