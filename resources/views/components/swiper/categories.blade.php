<swiper-container class="catalog-banner__slider" space-between="10px"
  keyboard="true" slides-per-view="2" loop="true"
  navigation="{{ json_encode([
      'prevEl' => '.categories .nav-arrow__prev',
      'nextEl' => '.categories .nav-arrow__next',
  ]) }}"
  breakpoints="{{ json_encode([
      '375' => [
          'slidesPerView' => 3,
          'spaceBetween' => 10,
      ],
      '768' => [
          'slidesPerView' => 4,
          'spaceBetween' => 20,
      ],
      '992' => [
          'slidesPerView' => 5,
          'spaceBetween' => 30,
      ],
      '1200' => [
          'slidesPerView' => 6,
          'spaceBetween' => 30,
      ],
  ]) }}">
  @foreach (range(1, 20) as $category)
    <swiper-slide>
      <x-categories.card :category="$category" />
    </swiper-slide>
  @endforeach
</swiper-container>
