export default () => ({
  product: $page.product,
  selected: [],
  fullReviews: false,
  get inCart() {
    let item = this.$store.cart.findItem(this.product, this.selected)
    return item
  },

  init() {
    const currentItems = this.$store.cart.findItems(this.product)

    // выбрать если есть в корзине
    if (currentItems.length) {
      this.selected = [...(currentItems[0].variation_ids || [])]
      this.$store.cart.updateItems(this.product)
    }
    // если нет то выбрать первую вариацию
    else {
      const id = this.product.variations[0]?.id
      if (id) {
        this.selected = [id]
      }
    }
  },

  addToCart() {
    if (this.inCart) {
      window.location.href = '/' + this.$store.lang + '/cart'
      return
    }
    this.$store.cart.addItem(this.product, this.selected)
  },
})
