<div class="review">
  <div class="review__name">{{ $review->name }}</div>
  <div class="review__text">
    {{ $review->comment }}
  </div>
  <div class="review__rating rating">
    <span class="review__rating--stars rating__stars"
      style="--percent: {{ rand(60, 100) }}%"></span>
  </div>
</div>
