import { register } from 'swiper/element/bundle'
addEventListener('DOMContentLoaded', () => {
  const swipers = document.querySelectorAll('swiper-container')

  swipers.forEach((swiperEl) => {
    swiperEl.addEventListener('init', (event) => {
      swiperEl.classList.add('swiper-initialized')
    })
  })
  register()
})
