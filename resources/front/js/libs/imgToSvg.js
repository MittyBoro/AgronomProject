import getCached from './cached'

const imgToSvg = async (parent) => {
  let elements
  if (
    parent.tagName.toLowerCase() === 'img' &&
    parent.classList.contains('to-svg')
  ) {
    elements = [parent]
  } else {
    elements = Array.from(parent.querySelectorAll('img.to-svg'))
  }

  // иначе дублируется загрузка
  for await (const image of elements) {
    await getCached(image.src)
      .then((res) => res.text())
      .then((data) => {
        const parser = new DOMParser()
        const svg = parser
          .parseFromString(data, 'image/svg+xml')
          .querySelector('svg')

        if (image.id) svg.id = image.id
        if (image.className) svg.classList = image.classList

        Object.keys(image.dataset).forEach(function (key) {
          svg.dataset[key] = image.dataset[key]
        })

        image.parentNode.replaceChild(svg, image)
      })
      .catch((error) => console.error(error))
  }
}

imgToSvg(document.body)

const observer = new MutationObserver((mutationsList) => {
  for (const mutation of mutationsList) {
    if (mutation.type === 'childList') {
      mutation.addedNodes.forEach((node) => {
        if (node instanceof HTMLElement) {
          imgToSvg(node)
        }
      })
    }
  }
})
// Начать отслеживание изменений в корневом элементе (например, body)
observer.observe(document.body, { childList: true, subtree: true })
