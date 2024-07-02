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

// .to_top
document.querySelector('.to_top')?.addEventListener('click', (e) => {
  window.scrollTo({ top: 0, behavior: 'smooth' })
})
document.addEventListener('scroll', (e) => {
  if (document.querySelector('footer')?.getBoundingClientRect().top < 500) {
    document.querySelector('.to_top')?.classList.add('active')
  } else {
    document.querySelector('.to_top')?.classList.remove('active')
  }
})
