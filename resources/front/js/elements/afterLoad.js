document.addEventListener('livewire:navigated', () => {
  // анимация перед загрузкой страницы выкл.
  let timerStart = Date.now()
  window.addEventListener('load', function () {
    window.timeEnd = Date.now() - timerStart
    let rem = 500 - window.timeEnd
    if (rem < 0) rem = 10
    setTimeout(() => {
      if (!window.manualPreloader) document.body.classList?.remove('preload')
    }, rem)
  })

  document.addEventListener(
    'invalid',
    function (e) {
      e.target.classList?.add('invalid')
    },
    true,
  )
  function valid(e) {
    if (e.target.tagName === 'VIDEO') {
      return
    }
    if (e.target.checkValidity()) {
      e.target.classList?.remove('invalid')
      e.target.classList?.add('valid')
    } else {
      e.target.classList?.add('invalid')
      e.target.classList?.remove('valid')
    }
  }
  document.addEventListener('input', valid, true)
  document.addEventListener('change', valid, true)
})
