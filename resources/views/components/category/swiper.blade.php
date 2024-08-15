<swiper-container
  @class(['categories__slider', $class ?? ''])
  space-between="10px"
  keyboard="true"
  slides-per-view="2"
  loop="true"
  initial-slide="{{ $activeIndex ?? 0 }}"
  scrollbar="true"
  scrollbar-snap-on-release="true"
  navigation="{{
    json_encode([
      'prevEl' => '.' . $className . ' .nav-arrow__prev',
      'nextEl' => '.' . $className . ' .nav-arrow__next',
    ])
  }}"
  breakpoints="{{
    json_encode([
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
    ])
  }}"
>
  @foreach ($categories as $category)
    <swiper-slide>
      <x-category.card
        :category="$category"
        :active="$activeIndex === $loop->index"
      />
    </swiper-slide>
  @endforeach
</swiper-container>
