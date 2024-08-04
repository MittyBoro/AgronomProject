import API from '../libs/api'

export default () => ({
  query: {},
  baseUrl: location.origin + location.pathname,
  loading: false,

  // Data
  title: $page.title,

  sortList: [
    { key: '', label: 'Сначала новое' },
    { key: 'price-desc', label: 'Цены по убыванию' },
    { key: 'price-asc', label: 'Цены по возрастанию' },
    { key: 'discount', label: 'Размер скидки' },
  ],

  activeSort: {},

  variations: $page.variations,

  // Initialization
  init() {
    // размещение блока сортировки в зависимости от ширины экрана

    // установка параметров фильтра из URL
    this.initQuery()

    // слушатель изменения в query, что бы прописать в URL
    let timerId
    this.$watch('query', (value) => {
      if (this.showMobileFilter) return

      clearTimeout(timerId)

      timerId = setTimeout(() => {
        this.setQuery(value)
      }, 1000)
    })
    this.$watch('query.sort', (value, oldValue) => {
      if (value != oldValue) {
        clearTimeout(timerId)
        this.setQuery(this.query)
      }

      this.setActiveSort()
    })
    this.setActiveSort()

    // заблокировать браузеру переход по ссылкам в каталоге
    this.$nextTick((e) => {
      this.preventCatalogLink('#catalog')
    })
  },

  /***************************************************
   * Работа с переменной this.query
   */
  // установка параметров из URL
  initQuery() {
    const urlParams = new URLSearchParams(location.search)
    const urlQuery = {}
    for (const [key, value] of Object.entries(this.query)) {
      if (urlParams.has(key)) {
        urlQuery[key] = urlParams.getAll(key)
      }
    }

    if (urlQuery.variations) urlQuery.variations = urlQuery.variations.join(',')

    this.query = {
      variations: urlQuery.variations || [],
      min_price: parseInt(urlQuery.min_price) || null,
      max_price: parseInt(urlQuery.max_price) || null,
      sort: urlQuery.sort || null,
    }
  },
  // установка параметров фильтра в URL
  setQuery(query) {
    const urlQuery = {}
    for (let [key, value] of Object.entries(query)) {
      if (
        (key == 'page' && value != 1) ||
        (Array.isArray(value) && value.length) ||
        (typeof value == 'string' && value)
      ) {
        if (Array.isArray(value)) value = value.join(',')
        urlQuery[key] = value
      }
    }
    const urlString = new URLSearchParams(urlQuery).toString()
    const newPath = (this.baseUrl + '?' + urlString).replace(/\?$/, '')
    this.getCatalog(newPath)
  },
  // сбросить параметры фильтра
  resetQuery() {
    this.query = {
      variations: [],
    }
  },

  // установить активную сортировку
  setActiveSort() {
    const urlParams = new URLSearchParams(location.search)
    const sortValue = urlParams.get('sort')

    this.activeSort = {}
    this.sortList.forEach((item) => {
      if (sortValue == item.key) {
        this.activeSort = item
      }
    })
    if (!this.activeSort.label) {
      this.activeSort = this.sortList[0]
    }
  },

  // Предотвращает переход по ссылкам в каталоге
  preventCatalogLink(selector) {
    document
      .querySelector(selector)
      .querySelectorAll('a')
      .forEach((a) => {
        a.addEventListener('click', (e) => {
          if (a.href.indexOf('catalog') !== -1) {
            e.preventDefault()
            this.getCatalog(a.href, !a.classList?.contains('more'))
          }
        })
      })
  },

  /***************************************************
   * обновление каталога
   */
  // Запрос каталога
  getCatalog(path, replace = true) {
    history.pushState({}, '', path)
    this.baseUrl = path.split('?')[0]
    this.loading = true

    API.get(path)
      .then((data) => this.setCatalog(data, replace))
      .catch((err) => alert(err))
      .then(() => {
        this.loading = false
      })
  },

  setCatalog(data, replace = true) {
    this.title = data.title
    document.title = data.meta_title

    const catalogList = document.querySelector('#catalog_list')

    if (replace) {
      catalogList.innerHTML = data.html
    } else {
      catalogList.querySelector('#catalog_pagination').remove()
      catalogList.insertAdjacentHTML('beforeend', data.html)
    }

    // Alpine.morph(catalogList, data.html, {})

    // повесить слушателей и рендер новый html
    document.dispatchEvent(new CustomEvent('catalogChanged', { bubbles: true }))
    this.preventCatalogLink('#catalog_list')
  },
})
