<a href="#" class="product">
  <span class="product__image">
    <img
      src="{{ vite_asset('images/logo.svg') }}"
      alt="{{ config('app.name') }}"
      class="object-cover default"
    />
    <span class="product__badge">-40%</span>
    <span class="product__actions">
      <span class="product__action product__action--like link">
        <x-icon src="icons/heart.svg" />
      </span>
      <span class="product__action product__action--open link">
        <x-icon src="icons/eye.svg" />
      </span>
    </span>
  </span>
  <span class="product__name link"><h3>Длинное название товара</h3></span>
  <span class="product__price">
    300₽
    <span class="product__price--old">450₽</span>
  </span>
  <span class="product__rating rating">
    <span
      class="product__rating--stars rating__stars"
      style="--percent: {{ rand(60, 100) }}%"
    ></span>
    <span class="product__rating--count rating__count">(66)</span>
  </span>
</a>
