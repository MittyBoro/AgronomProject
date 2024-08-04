<div class="products-card"
  onclick="location.href='/products/{{ $item->slug }}'">
  <div class="products-card__image">
    <x-a.picture class="object-cover" :media="$item->media->first()" />
    @if ($item->discount > 0)
      <span class="products-card__badge">-{{ $item->discount }}%</span>
    @endif
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
    <h3><a class="link"
        href="/products/{{ $item->slug }}">{{ $item->title }}</a></h3>
  </div>
  <div class="products-card__price">
    @if ($item->discount > 0)
      <span>{{ price_formatter($item->total_price) }}₽</span>
      <span
        class="products-card__price--old">{{ price_formatter($item->price) }}₽</span>
    @else
      <span>{{ price_formatter($item->price) }}₽</span>
    @endif
  </div>
  @if ($item->reviews_count)
    <div class="products-card__rating rating">
      <div class="products-card__rating--stars rating__stars"
        style="--percent: {{ ($item->reviews_avg_rating / 5) * 100 }}%">
      </div>
      <div class="products-card__rating--count rating__count">
        ({{ $item->reviews_count }})</div>
    </div>
  @endif
</div>
