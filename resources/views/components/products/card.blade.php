<div class="products-card">
  <div class="products-card__image">
    <img class="object-cover" src="{{ Vite::front('images/product-demo.png') }}"
      alt="{{ config('app.name') }}" />
    <span class="products-card__badge">-40%</span>
    <span class="products-card__actions">
      <span class="products-card__action products-card__action--like link">
        <x-a.icon src="icons/heart.svg" />
      </span>
      <span class="products-card__action products-card__action--open link">
        <x-a.icon src="icons/eye.svg" />
      </span>
    </span>
  </div>
  <div class="products-card__name">
    <h3><a class="link" href="#">Длинное название товара</a></h3>
  </div>
  <div class="products-card__price">
    300₽
    <span class="products-card__price--old">450₽</span>
  </div>
  <div class="products-card__rating rating">
    <div class="products-card__rating--stars rating__stars"
      style="--percent: {{ rand(60, 100) }}%"></div>
    <div class="products-card__rating--count rating__count">(66)</div>
  </div>
</div>
