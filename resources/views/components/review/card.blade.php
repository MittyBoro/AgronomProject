<div class="review__card">
  <div class="review__card-name">{{ $review->name }}</div>
  @empty($hideProduct)
    <a class="review__card-product link"
      href="/products/{{ $review->product->slug }}">к
      {{ $review->product->title }}</a>
  @endempty
  <div class="review__card-text">
    {{ $review->comment }}
  </div>
  <div class="review__card-rating rating">
    <span class="review__card-rating--stars rating__stars"
      style="--percent: {{ ($review->rating / 5) * 100 }}%"></span>
  </div>
</div>
