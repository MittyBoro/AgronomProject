import API from '../libs/api'
import noUiSlider from 'nouislider'

export default () => ({
  query: {},
  baseUrl: location.origin + location.pathname,
  loading: false,
  showMobileFilter: false,
  rangeSlider: document.querySelector('#range_slider'),

  // Data
  title: $page.title,
  priceRange: {
    min: parseInt($page.priceRange.min || 0),
    max: parseInt($page.priceRange.max || 0),
  },
  sortList: [
    { key: '', label: 'Сначала новое' },
    { key: 'price-desc', label: 'Цены по убыванию' },
    { key: 'price-asc', label: 'Цены по возрастанию' },
  ],

  activeSort: {},

  categories: [
    ...$page.categories,
    {
      slug: '',
      title: 'Весь каталог',
    },
  ],
  variations: $page.variations,

  // Initialization
  init() {
    // размещение блока сортировки в зависимости от ширины экрана
    window.addEventListener('resize', () => this.moveSortByScreen())
    this.moveSortByScreen()

    // установка блока ценового диапазона
    this.initRangeSlider()

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
    })

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

  // получить активную сортировку
  setActiveSort() {
    const urlParams = new URLSearchParams(location.search)
    const sortValue = urlParams.get('sort')

    this.sort.forEach((item) => {
      const itemUrlParams = new URLSearchParams(item.href)
      if (sortValue == itemUrlParams.get('sort')) {
        this.activeSort = item
      }
    })
  },

  /***************************************************
   * Методы для работы с DOM
   */
  // установка блока сортировки в зависимости от ширины экрана
  moveSortByScreen() {
    const sortingEl =
      this.$refs.sortingEl.content.firstElementChild.cloneNode(true)

    let to

    if (window.innerWidth <= 768) {
      to = document.querySelector('#sorting-mobile > div')
    } else {
      to = document.querySelector('#sorting-desktop > div')
    }

    Alpine.morph(to, sortingEl)
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
   * Установка блока ценового диапазона
   * через noUiSlider
   */
  // Укажите ценовой диапазон
  initRangeSlider() {
    noUiSlider.create(this.rangeSlider, {
      start: [0, 0],
      connect: true,
      step: this.$store.lang == 'ru' ? 100 : 1,
      tooltips: {
        to: (value) => new Intl.NumberFormat('ru-RU').format(value),
      },
      range: {
        min: parseInt(this.priceRange.min || 0),
        max: parseInt(this.priceRange.max || 0),
      },
    })

    this.rangeSlider.noUiSlider.on('change', (values, handle) => {
      this.query.min_price = values[0] <= this.priceRange.min ? null : values[0]
      this.query.max_price = values[1] >= this.priceRange.max ? null : values[1]
    })

    this.updateRangeSlider()
  },

  // Обновление ценового диапазона
  updateRangeSlider() {
    const urlParams = new URLSearchParams(location.search)

    this.rangeSlider.noUiSlider.updateOptions({
      range: this.priceRange,
    })
    this.rangeSlider.noUiSlider.set([
      parseInt(urlParams.get('min_price') || this.priceRange.min),
      parseInt(urlParams.get('max_price') || this.priceRange.max),
    ])
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

    this.priceRange = {
      min: parseInt(data.priceRange.min || 0),
      max: parseInt(data.priceRange.max || 0),
    }
    this.updateRangeSlider()

    this.variations = data.variations

    const catalogList = document.querySelector('#catalog_list')

    if (replace) {
      catalogList.innerHTML = data.html
      this.$root.scrollIntoView()
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
