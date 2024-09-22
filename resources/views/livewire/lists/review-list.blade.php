<section class="reviews__section" id="reviews">
  @if ($reviews->isNotEmpty() || ($canCreateReview && $productId))
    <div class="reviews__container container">
      <x-main.title
        :pretitle="$pretitle ?? null"
        :title="$title ?? null"
        :button="$button ?? null"
      />
      @if ($canCreateReview && $productId)
        <livewire:components.review-form :productId="$productId" />
      @endif

      @if ($reviews->isNotEmpty())
        <div class="reviews__list">
          @foreach ($reviews as $review)
            <div :key="$review->id" class="review__card">
              <div class="review__card-name">{{ $review->name }}</div>
              @if ($review->relationLoaded('product'))
                <a
                  class="review__card-product link"
                  href="/products/{{ $review->product->slug }}"
                  wire:navigate
                >
                  к {{ $review->product->title }}
                </a>
              @endif

              <div class="review__card-text">
                {{ $review->comment }}
              </div>
              <div class="review__card-rating rating">
                <span
                  class="review__card-rating--stars rating__stars"
                  style="--percent: {{ ($review->rating / 5) * 100 }}%"
                ></span>
              </div>
            </div>
          @endforeach
        </div>
        @if ($reviews instanceof \Illuminate\Pagination\LengthAwarePaginator)
          <div class="catalog__pagination pagination">
            {{ $reviews->links('components.main.pagination', data: ['scrollTo' => '#reviews']) }}
          </div>
        @endif
      @endif
    </div>
  @endif
</section>
