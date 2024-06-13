// открыть меню
document.querySelectorAll('.hamburger').forEach((element) => {
  element.addEventListener('click', (e) => {
    document.querySelector('.header-box').classList.toggle('active')
  })
})

// закрыть меню
document.querySelectorAll('.menu-box').forEach((element) => {
  element.addEventListener('click', (e) => {
    if (
      e.target.classList.contains('prevent') ||
      e.target.closest('.prevent')
    ) {
      return
    }

    document.querySelector('.header-box').classList.remove('active')
  })
})

document.querySelectorAll('.fixed-buttons').forEach((element) => {
  let iconIndex = 0
  const icons = []

  element.querySelectorAll('[data-type]').forEach((el) => {
    icons.push(el.dataset.type)
  })

  const buttonIcon = document.querySelector('.floating-button .button-icon')
  const floatingButton = document.querySelector('.floating-button')
  const expandedButtons = document.getElementById('expanded-buttons')

  function changeIcon() {
    buttonIcon.className = 'button-icon ' + icons[iconIndex]
    iconIndex = (iconIndex + 1) % icons.length
  }

  let thenHide = true

  function showText(e = null) {
    if (e) {
      thenHide = false
    }
    floatingButton.classList.add('full')
  }
  function hideText(e) {
    if (e) {
      thenHide = true
    }
    if (!thenHide) return
    floatingButton.classList.remove('full')
  }

  const timerSH = setInterval(() => {
    showText()
    setTimeout(hideText, 1300)
  }, 5000)

  floatingButton.addEventListener('mouseenter', showText)
  floatingButton.addEventListener('mouseleave', hideText)

  setInterval(changeIcon, 1300)

  floatingButton.addEventListener('click', () => {
    if (expandedButtons.classList.contains('show')) {
      expandedButtons.classList.remove('show')
    } else {
      clearInterval(timerSH)
      expandedButtons.classList.add('show')
    }
  })
})
