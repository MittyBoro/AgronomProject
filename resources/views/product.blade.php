<x-layouts.main body_name="single-product">
  <x-breadcrumbs
    :list="[['Каталог', '/catalog'], ['Название товара', null]]"
  />

  {{-- product --}}
  <section class="product product__section">
    <div class="product__container container">
      <x-swiper.product-gallery />

      <div class="product__info">
        <div class="product__title"><h1>Название товара</h1></div>

        <div class="product__rating rating">
          <div
            class="product__rating--stars rating__stars"
            style="--percent: {{ rand(60, 100) }}%"
          ></div>
          <div class="product__rating--count rating__count">(150 Отзывов)</div>
          <div class="product__rating-separator">|</div>
          <div class="product__availability green">В наличии</div>
        </div>

        <div class="product__price">
          300₽
          <span class="product__price--old">450₽</span>
        </div>

        <div class="product__description prose">
          <p>
            Lorem ipsum dolor sit amet consectetur. Vitae vitae bibendum felis
            rhoncus rhoncus. Facilisis tempor eget sed sagittis neque fermentum
            viverra gravida.
          </p>
        </div>

        <div class="product__info-separator"></div>

        <div class="product__options">
          <div class="product__volume">
            <div class="button button-alt product__volume--label">Объем:</div>
            <button class="button button-alt product__volume--button">
              50 мл
            </button>
            <button class="button button-alt product__volume--button">
              100 мл
            </button>
            <button class="button product__volume--button">200 мл</button>
            <button class="button button-alt product__volume--button">
              300 мл
            </button>
          </div>
        </div>
        <div class="product__actions">
          <div class="product__quantity">
            <div
              class="button button-alt product__button product__button--quantity product__button--minus"
            >
              <x-icon src="icons/minus.svg" />
            </div>
            <input
              class="button button-input product__button product__button--quantity product__button--input"
              value="2"
              type="number"
              min="1"
              max="999"
            />
            <div
              class="button button-alt product__button--quantity product__button--plus"
            >
              <x-icon src="icons/plus.svg" />
            </div>
          </div>
          <button class="button product__button product__button--cart">
            В корзину
          </button>
          <button
            class="button button-alt product__button product__button--favorite"
          >
            <x-icon src="icons/heart.svg" />
          </button>
        </div>
        <div class="product__delivery">
          <x-icon class="product__sipping-icon" src="icons/delivery.svg" />
          <div class="product__sipping-text">
            <div class="product__sipping-title">Бесплатная доставка</div>
            <a href="#" class="underline link">
              Доставляем товары по всей России
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- popular --}}
  <section class="popular popular__section">
    <div class="popular__container container">
      <div class="popular__subtitle subtitle">Лучшее за месяц</div>
      <div class="popular__title title">
        <h2>Самое популярное</h2>
        <a href="#" class="button popular__button">В каталог</a>
      </div>
      <div class="popular__products products__list">
        @foreach (range(1, 4) as $product)
          <x-products.card />
        @endforeach
      </div>
    </div>
  </section>
</x-layouts.main>
