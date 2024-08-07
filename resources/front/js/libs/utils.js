window.price_formatter = (price) => {
  return new Intl.NumberFormat('ru-RU', {
    style: 'currency',
    currency: 'RUB',
  }).format(price)
}
window.sklonenie = function (number, txt, cases = [2, 0, 1, 1, 1, 2]) {
  return txt[
    number % 100 > 4 && number % 100 < 20
      ? 2
      : cases[number % 10 < 5 ? number % 10 : 5]
  ]
}

window.setScrollbarWidth = function (
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

window.loadJs = function (url) {
  let script = document.createElement('script')
  script.src = url
  script.setAttribute('async', 'true')
  document.documentElement.firstChild.appendChild(script)
}
