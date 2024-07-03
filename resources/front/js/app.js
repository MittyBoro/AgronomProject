import './elements/afterLoad'
import './elements/layout'
import './elements/range'
import './elements/popup'

// import './alpine/app'

import.meta.glob('../images/**/**', { query: '?url' })

import { register } from 'swiper/element/bundle'
addEventListener('DOMContentLoaded', () => {
  register()
})
