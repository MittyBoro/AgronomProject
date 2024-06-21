<swiper-container
  class="product__slider"
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
  @foreach (range(1, 3) as $banner)
    <swiper-slide>
      <div class="product__image">
        <img
          src="{{ vite_asset('images/product-demo.png') }}"
          alt="{{ config('app.name') }}"
          class="object-cover"
        />
      </div>
    </swiper-slide>
  @endforeach
</swiper-container>
