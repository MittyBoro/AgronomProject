<section class="banner__section">
  <div class="banner__container container">
    <swiper-container class="banner__slider" pagination="true"
      pagination-clickable="true" space-between="30px" autoplay="true"
      autoplay-pause-on-mouse-enter="true" mousewheel="true"
      mousewheel-force-to-axis="true" loop="true" delay="5000"
      keyboard="true">
      @foreach ($banners as $banner)
        <swiper-slide>
          <div class="banner__card"
            onclick="location.href='{{ $banner->button_url }}'">
            <x-main.picture class="object-cover" :media="$banner->media->first()" />
            <div class="banner__card-text">
              <div class="banner__card-title">
                Отрава со скидкой {{ rand(1, 20) }}%
              </div>
              @isset($banner->button_text)
                <a class="button" href="{{ $banner->button_url }}"
                  wire:navigate>{{ $banner->button_text }}</a>
              @endisset
            </div>
          </div>
        </swiper-slide>
      @endforeach
    </swiper-container>

  </div>
</section>
