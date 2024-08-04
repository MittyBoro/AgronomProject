<x-layouts.main body_name="single-product" :page="$product">
  {{-- breadcrumbs --}}
  <x-a.breadcrumbs :list="[['Каталог', '/catalog'], [$product->title, null]]" />

  {{-- product --}}
  <section class="product product__section" x-data="product">
    <div class="product__container container">
      <x-swiper.product-gallery :media="$product->media" />

      {{-- right info --}}
      <div class="product__info">

        {{-- title --}}
        <div class="product__title">
          <h1>{{ $product->title }}</h1>
        </div>

        {{-- rating and availability --}}
        <div class="product__rating rating">
          <div class="product__rating--stars rating__stars"
            style="--percent: {{ round($product->reviews->avg('rating') * 10) }}%">
          </div>
          <div class="product__rating--count rating__count">
            ({{ $product->reviews->count() }})</div>
          <div class="product__rating-separator">|</div>
          <div @class([
              'product__availability',
              match ($product->stock) {
                  0 => 'red',
                  range(1, 10) => 'yellow',
                  default => 'green',
              },
          ])>
            {{ match ($product->stock) {
                0 => 'Нет в наличии',
                range(1, 10) => 'Осталось мало',
                default => 'В наличии',
            } }}
          </div>
        </div>

        {{-- price  --}}
        <div class="product__price">
          {{ price_formatter($product->total_price) }}₽
          @if ($product->price !== $product->total_price)
            <span
              class="product__price--old">{{ price_formatter($product->price) }}₽</span>
            <span
              class="products__badge">-{{ (float) $product->discount }}%</span>
          @endif
        </div>

        {{-- description  --}}
        <div class="product__description prose">
          {{ $product->description }}
        </div>

        <div class="product__info-separator"></div>

        {{-- options  --}}
        <div class="product__options">
          <template x-for="list, group in variations">
            <div class="product__volume">
              <div class="button button-alt product__volume--label"><span
                  x-text="group"></span>:</div>
              <div class="product__volume-buttons">
                <template x-for="variation in list">
                  <button class="button button-alt product__volume--button"
                    x-text="variation.title"></button>
                </template>
              </div>
            </div>
          </template>
        </div>

        {{-- actions  --}}
        <div class="product__actions">
          {{-- quantity --}}
          <div class="product__quantity">
            <div
              class="button button-alt product__button product__button--quantity product__button--minus">
              <x-a.icon src="icons/minus.svg" />
            </div>
            <input
              class="button button-input product__button product__button--quantity product__button--input"
              type="number" value="2" min="1" max="999" />
            <div
              class="button button-alt product__button--quantity product__button--plus">
              <x-a.icon src="icons/plus.svg" />
            </div>
          </div>
          {{-- to cart --}}
          <button class="button product__button product__button--cart">
            В корзину
          </button>

          {{-- to wishlist  --}}
          <button
            class="button button-alt product__button product__button--favorite">
            <x-a.icon src="icons/heart.svg" />
          </button>
        </div>

        {{-- delivery --}}
        <div class="product__delivery">
          <x-a.icon class="product__sipping-icon" src="icons/delivery.svg" />
          <div class="product__sipping-text">
            <div class="product__sipping-title">Бесплатная доставка</div>
            <a class="link underline" href="#">
              Доставляем товары по всей России
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- popular --}}
  @if ($similar)
    <section class="product__popular popular popular__section">
      <div class="popular__container container">
        <div class="popular__subtitle subtitle">Лучшее за месяц</div>
        <div class="popular__title title">
          <h2>Самое популярное</h2>
          <a class="button popular__button" href="/catalog">В каталог</a>
        </div>
        <div class="popular__products products__list">
          @foreach ($similar as $item)
            <x-products.card :item="$item" />
          @endforeach
        </div>
      </div>
    </section>
  @endif

  <x-slot:body>
    <script>
      const $page = {
        product: @json($product),
      }
    </script>
  </x-slot>
</x-layouts.main>
