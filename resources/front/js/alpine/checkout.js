import API from '../libs/api'
import cart from './cart'

export default () => ({
  ...cart($page.checkout_list),
  subTotal: $page.subTotal,
  shipping: $page.shipping || 0,

  get total() {
    return this.subTotal + this.shipping
  },

  loading: false,

  form: Alpine.$persist({ address: {} }).as('checkout_form'),

  submit() {
    this.form.total = this.total
    this.loading = true
    API.post(`/${this.$store.lang}/checkout/${this.hash}`, this.form)
      .then((data) => {
        if (!data.url) {
          throw new Error('Проблемы с оплатой платежа. Повторите попытку')
        }
        // очистить корзину
        this.$store.cart.clear()
        // редирект
        window.location.href = data.url
      })
      .catch((err) => {
        alert(`Ошибка:\n` + err.message)
      })
      .then(() => {
        this.loading = false
      })
  },
})
