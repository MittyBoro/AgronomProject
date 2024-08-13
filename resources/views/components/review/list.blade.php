  <section class="reviews__section">
    <div class="reviews__container container">
      <x-main.title :pretitle="$pretitle ?? null" :title="$title ?? null" :button="$button ?? null" />
      <div class="reviews__list">
        @foreach ($reviews as $review)
          <x-review.card :$review />
        @endforeach
      </div>
    </div>
  </section>
