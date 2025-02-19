// https://toughengineer.github.io/demo/slider-styler/slider-styler.html

document.addEventListener('DOMContentLoaded', () => {
  const getState = (e) => {
    const result = {}
    result.value = e.value
    result.min = e.min ? e.min : 0
    result.max = e.max ? e.max : 100
    result.progress = Number(
      ((result.value - result.min) * 100) / (result.max - result.min),
    )

    return result
  }
  document.querySelectorAll('input[type="range"]').forEach((element) => {
    const bubble = element.parentElement.querySelector('.bubble')

    const setProgress = (e) => {
      const state = getState(e)
      if (bubble) {
        bubble.style.setProperty('--value', `'${state.value}'`)
        bubble.style.setProperty('--progress', state.progress + '%')
      }
      e.style.setProperty('--value', state.value)
      e.style.setProperty('--progress', state.progress + '%')
    }

    setProgress(element)

    element.addEventListener('input', () => {
      setProgress(element)
    })

    // изменение видимости
    const intersectionObserver = new IntersectionObserver((entries) => {
      for (let entry of entries) {
        if (entry.isIntersecting) {
          setProgress(element)
        }
      }
    })
    intersectionObserver.observe(element)

    // изменение состояния
    const observer = new MutationObserver((mutationsList, observer) => {
      for (let mutation of mutationsList) {
        if (
          mutation.type === 'attributes' &&
          mutation.attributeName === 'class'
        ) {
          setProgress(element)
        }
      }
    })
    observer.observe(element, {
      attributes: true,
    })
  })
})
