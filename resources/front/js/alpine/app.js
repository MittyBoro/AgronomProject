import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse'
import persist from '@alpinejs/persist'
import morph from '@alpinejs/morph'
import mask from '@alpinejs/mask'

import catalog from './catalog'
import product from './product'
import checkout from './checkout'
import cart from './cart'

import { formatPrice } from '../libs/methods'

Alpine.plugin(collapse)
Alpine.plugin(persist)
Alpine.plugin(morph)
Alpine.plugin(mask)

window.Alpine = Alpine

Alpine.store('lang', document.documentElement.lang)

Alpine.magic('formatPrice', () => (int) => formatPrice(int))

Alpine.store('cart', cart(Alpine.$persist([]).as('cart_list')))
addEventListener('storage', () =>
  Alpine.store('cart', cart(Alpine.$persist([]).as('cart_list'))),
)

if (typeof $page !== 'undefined') {
  if (typeof $page?.checkout_list !== 'undefined') {
    Alpine.data('checkout', checkout)
  }
  if (typeof $page?.product !== 'undefined') {
    Alpine.data('product', product)
  }
  if (typeof $page?.catalog !== 'undefined') {
    Alpine.data('catalog', catalog)
  }
}

Alpine.start()
