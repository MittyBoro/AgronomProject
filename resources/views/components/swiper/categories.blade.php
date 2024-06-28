<swiper-container
  class="catalog-banner__slider"
  space-between="30px"
  keyboard="true"
  slides-per-view="3"
  loop="true"
  navigation="{{
    json_encode([
      'prevEl' => '.categories .nav-arrow__prev',
      'nextEl' => '.categories .nav-arrow__next',
    ])
  }}"
  breakpoints="{{
    json_encode([
      '768' => [
        'slidesPerView' => 4,
      ],
      '992' => [
        'slidesPerView' => 5,
      ],
      '1200' => [
        'slidesPerView' => 6,
        'spaceBetween' => 30,
      ],
    ])
  }}"
>
  @foreach (range(1, 20) as $category)
    <swiper-slide>
      <a href="#" class="category">
        <span class="category__icon">
          <img
            src="{{ vite_asset('images/logo.svg') }}"
            alt="Категория"
            class="default"
          />
        </span>
        <span class="category__name">Категория {{ $category }}</span>
      </a>
    </swiper-slide>
  @endforeach
</swiper-container>
