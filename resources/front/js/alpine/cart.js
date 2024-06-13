export default (list = []) => ({
  list: list,
  loading: false,

  get count() {
    return this.list?.reduce((acc, item) => acc + item.quantity, 0) || 0
  },

  get hash() {
    let sendList = this.list?.map((item) => ({
      id: item.id,
      q: item.quantity,
      v: item.variation_ids,
    }))
    sendList.push(parseInt(Date.now() / 1000))
    let orderData = JSON.stringify(sendList)
    return btoa(orderData)
  },

  get subTotal() {
    return (
      this.list?.reduce((acc, item) => acc + item.price * item.quantity, 0) || 0
    )
  },

  findItem(product, variations) {
    return this.list?.find(
      (item) =>
        item.id === product.id &&
        JSON.stringify(item.variation_ids?.sort()) ===
          JSON.stringify(variations?.sort()),
    )
  },

  findItems(product) {
    return this.list?.filter((item) => item.id === product.id)
  },

  updateItems(product) {
    this.list
      ?.filter((item) => item.id == product.id)
      .forEach((item) => {
        item.preview = product.preview
        item.url = product.url
        item.title = product.title
        item.price = product.price
      })
  },

  addItem(product, selectedVariations, quantity = 1, inctre) {
    const variations = JSON.parse(JSON.stringify(selectedVariations))

    const item = this.findItem(product, variations)

    if (item) {
      item.quantity += quantity
      return
    }

    const cartItem = {
      id: product.id,
      quantity: quantity,
      preview: product.preview,
      url: product.url,
      title: product.title,
      price: product.price,
      variation_ids: variations,
      variation_text: '',
    }

    if (product.variations?.length && variations?.length) {
      cartItem.variation_text = product.variations
        .filter((item) => variations.includes(item.id.toString()))
        .map((item) => `${item.group.name}: ${item.value}`)
        .join(', ')
    }

    this.list.push(cartItem)
  },

  removeItemByIndex(index) {
    this.list.splice(index, 1)
  },

  removeItemByValue(value) {
    this.list = this.list.filter(
      (item) =>
        item.id !== value.id ||
        !item.variation_ids.every((v) => value.variation_ids.includes(v)),
    )
  },

  clear() {
    this.list = []
  },

  restore(products) {
    products.forEach((product) => this.removeItemByValue(product))
    products.forEach((product) =>
      this.addItem(product, product.variation_ids, product.quantity),
    )
  },
})
