import Swiper, { Navigation, Autoplay, Keyboard } from 'swiper'

Swiper.use([Navigation, Autoplay, Keyboard])

import 'swiper/css'

// слайдер home ПОПУЛЯРНЫЕ НОВИНКИ
new Swiper('.home-novelties-box .swiper', {
  slidesPerView: 1,
  centeredSlides: true,

  loop: true,
  loopedSlides: 4,

  keyboard: true,
  slideToClickedSlide: true,

  autoplay: {
    delay: 7000,
    pauseOnMouseEnter: true,
    disableOnInteraction: false,
  },

  navigation: {
    nextEl: '.home-novelties-box .sw-next',
    prevEl: '.home-novelties-box .sw-prev',
  },

  on: {
    snapIndexChange: (swiper) => {
      let intEl = document.querySelector('.home-novelties-box .sw-current-int')
      if (intEl) intEl.innerHTML = (swiper.realIndex + 1).toString()
    },
    slideChange: (swiper) => {
      let current = swiper.slides[swiper.activeIndex]

      let name = current.querySelector('.n-name').innerText
      let price = current.querySelector('.n-price').innerText

      document.querySelector('.home-novelties-box .prod-name').innerHTML = name
      document.querySelector('.home-novelties-box .prod-price').innerHTML =
        price
    },
  },
})
