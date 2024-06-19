import Swiper, {
  Navigation,
  Autoplay,
  Thumbs,
  Keyboard,
  EffectFade,
  Scrollbar,
  Mousewheel,
} from 'swiper'

Swiper.use([
  Navigation,
  Autoplay,
  Thumbs,
  Keyboard,
  EffectFade,
  Scrollbar,
  Mousewheel,
])

import 'swiper/css'
import 'swiper/css/effect-fade'
import 'swiper/css/scrollbar'

// product-gallery
document.querySelectorAll('.product-box .gallery-col').forEach((el) => {
  // слайдер товары
  let thumbContainer = el.querySelector('.thumbs-row .swiper')

  let galleryThumbs = new Swiper(thumbContainer, {
    spaceBetween: 6,
    slidesPerView: 5,
    scrollbar: false,
    mousewheel: true,
    scrollbar: {
      el: '.swiper-scrollbar',
      hide: false,
      draggable: true,
    },
    on: {
      init: (swiper) => {
        if (swiper.slides.length < 2) {
          el.classList.add('single')
        }
      },
    },
    breakpoints: {
      992: {
        spaceBetween: 10,
        slidesPerView: 'auto',
        direction: 'vertical',
      },
    },
  })

  let topContainer = el.querySelector('.full-row .swiper')

  new Swiper(topContainer, {
    spaceBetween: 15,
    loop: true,
    effect: 'fade',

    navigation: {
      nextEl: el.querySelector('.sw-next'),
      prevEl: el.querySelector('.sw-prev'),
    },
    thumbs: {
      swiper: galleryThumbs,
    },
  })

  if (topContainer) {
  }
})
