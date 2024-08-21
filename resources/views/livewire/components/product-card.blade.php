<div
  class="product__card"
  onclick="Livewire.navigate('/products/{{ $product->slug }}')"
>
  <div class="product__card-image">
    <a
      class="product__card-image--link"
      href="/products/{{ $product->slug }}"
      wire:navigate
    >
      <x-main.picture class="object-cover" :media="$product->media->first()" />
    </a>
    @if ($product->discount > 0)
      <span class="product__card-badge">-{{ $product->discount }}%</span>
    @endif

    <span class="product__card-actions">
      <span
        wire:click.stop="toggleWishlist"
        class="product__card-action product__card-action--like link"
        :class="{'active': $wire.inWishlist}"
      >
        <x-main.icon src="icons/heart.svg" />
      </span>
      <a
        href="/products/{{ $product->slug }}"
        wire:navigate
        class="product__card-action product__card-action--open link"
      >
        <x-main.icon src="icons/eye.svg" />
      </a>
    </span>
  </div>
  <div class="product__card-name">
    <a class="link" href="/products/{{ $product->slug }}" wire:navigate>
      {{ $product->title }}
    </a>
  </div>
  <div class="product__card-price">
    @if ($product->price)
      @if ($product->discount > 0)
        <span>{{ price_formatter($product->total_price) }}₽</span>
        <span class="product__card-price--old">
          {{ price_formatter($product->price) }}₽
        </span>
      @else
        <span>{{ price_formatter($product->price) }}₽</span>
      @endif
    @endif
  </div>
  @if ($product->reviews_count)
    <div class="product__card-rating rating">
      <div
        class="product__card-rating--stars rating__stars"
        style="--percent: {{ ($product->reviews_avg_rating / 5) * 100 }}%"
      ></div>
      <div class="product__card-rating--count rating__count">
        ({{ $product->reviews_count }})
      </div>
    </div>
  @endif
</div>
