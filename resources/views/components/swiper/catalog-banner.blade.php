<swiper-container
  class="catalog-banner__slider"
  pagination="true"
  pagination-clickable="true"
  space-between="30px"
  autoplay="true"
  autoplay-pause-on-mouse-enter="true"
  mousewheel="true"
  mousewheel-force-to-axis="true"
  loop="true"
  delay="5000"
  keyboard="true"
>
  @foreach (range(1, 7) as $banner)
    <swiper-slide>
      <div class="catalog-banner">
        <img
          src="{{ vite_asset('images/catalog-banner-demo.png') }}"
          alt="Отрава со скидкой 10%"
          class="object-cover"
        />
        <div class="catalog-banner__text">
          <div class="catalog-banner__title">
            Отрава со скидкой {{ rand(1, 20) }}%
          </div>
          <a href="#" class="button">Купить</a>
        </div>
      </div>
    </swiper-slide>
  @endforeach
</swiper-container>
