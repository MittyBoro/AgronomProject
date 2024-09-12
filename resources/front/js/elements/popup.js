document.addEventListener('livewire:navigated', function () {
  // popup окна

  window.openPopup = function (popupClass, popupData = null) {
    let popup = document.querySelector(popupClass)
    if (!popup) return

    document
      .querySelectorAll('.popups > .active')
      .forEach((el) => el.classList.remove('active'))
    popup.classList.add('active')

    document.documentElement.style.overflow = 'hidden'

    setScrollbarWidth()

    const event = new CustomEvent('popupOpened', {
      detail: {
        popupClass: popupClass,
        popupData: popupData,
        popup: popup,
      },
    })
    document.dispatchEvent(event)

    window.popupClass = popupClass

    history.pushState({ popup: popupClass }, '')
  }

  window.closePopups = function () {
    document
      .querySelectorAll('.popups > .active')
      .forEach((el) => el.classList.remove('active'))

    document.documentElement.style.overflow = null

    window.popupClass = null

    const event = new CustomEvent('popupClosed', {})
    document.dispatchEvent(event)
  }

  document.querySelectorAll('.popup__close').forEach((el) => {
    el.addEventListener('click', (e) => {
      e.preventDefault()
      closePopups()
    })
  })
  document.querySelectorAll('.popup').forEach((el) => {
    el.addEventListener('click', (e) => {
      if (e.target.classList.contains('popup')) closePopups()
    })
  })

  document.onkeydown = function (evt) {
    evt = evt || window.event
    var isEscape = false
    if ('key' in evt) {
      isEscape = evt.key === 'Escape' || evt.key === 'Esc'
    } else {
      isEscape = evt.keyCode === 27
    }
    if (isEscape) {
      closePopups()
    }
  }

  window.addEventListener('popstate', () => {
    closePopups()
    history.pushState({ popup: false }, '')
  })

  document.onkeydown = function (evt) {
    evt = evt || window.event
    var isEscape = false
    if ('key' in evt) {
      isEscape = evt.key === 'Escape' || evt.key === 'Esc'
    } else {
      isEscape = evt.keyCode === 27
    }
    if (isEscape) {
      closePopups()
    }
  }

  document.querySelectorAll('[data-popup]').forEach((el) => {
    el.addEventListener('click', (e) => {
      e.preventDefault()
      openPopup(el.dataset.popup, el.dataset.popupData)
    })
  })

  // закрыть меню
  document.querySelectorAll('.popup__menu a').forEach((element) => {
    element.addEventListener('click', function () {
      window.closePopups()
    })
  })
})

const setScrollbarWidth = function (
  propertyName = '--scrollbar-width',
  className = null,
) {
  // Creating invisible container
  const outer = document.createElement('div')
  if (className) outer.classList.add(className)
  outer.style.visibility = 'hidden'
  outer.style.overflow = 'scroll' // forcing scrollbar to appear
  outer.style.msOverflowStyle = 'scrollbar' // needed for WinJS apps
  document.body.appendChild(outer)

  // Creating inner element and placing it in the container
  const inner = document.createElement('div')
  outer.appendChild(inner)

  // Calculating difference between container's full width and the child width
  const scrollbarWidth = outer.offsetWidth - inner.offsetWidth

  // Removing temporary elements from the DOM
  outer.parentNode.removeChild(outer)

  document.documentElement.style.setProperty(
    propertyName,
    scrollbarWidth + 'px',
  )

  return scrollbarWidth
}
