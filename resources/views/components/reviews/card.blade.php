<div class="review">
  <div class="review__name">{{ $item->name }}</div>
  <div class="review__text">
    {{ $item->comment }}
  </div>
  <div class="review__rating rating">
    <span class="review__rating--stars rating__stars"
      style="--percent: {{ ($item->rating / 5) * 100 }}%"></span>
  </div>
</div>
