import './elements/afterLoad'
import './elements/layout'
import './elements/range'
import './elements/popup'
import './alpine/app'

// import './alpine/app'

import.meta.glob('../images/**/**', { query: '?url' })
import.meta.glob('../icons/**/**', { query: '?url' })

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
