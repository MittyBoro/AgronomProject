export default () => ({
  product: $page.product,
  variations: [],
  selected: undefined,
  itemCount: 1,
  get stock() {
    let stock = this.product.stock
    if (this.selected.length) {
      stock = this.product.variations.find(
        (item) => item.id == this.selected,
      )?.stock
    }
    return stock
  },

  init() {
    if (this.product.variations?.length) {
      this.selected = this.product.variations[0].id

      this.variations = this.product.variations?.reduce((acc, item) => {
        const groupTitle = item.group.title
        if (!acc[groupTitle]) {
          acc[groupTitle] = []
        }
        acc[groupTitle].push(item)
        return acc
      }, {})
    }

    this.$watch('itemCount', (value) => {
      if (value < 1) this.itemCount = 1
      if (value > 100) this.itemCount = 100
      if (value > this.stock) this.itemCount = this.stock
    })
  },

  addToCart() {
    if (this.inCart) {
      window.location.href = '/' + this.$store.lang + '/cart'
      return
    }
    this.$store.cart.addItem(this.product, this.selected)
  },
})
