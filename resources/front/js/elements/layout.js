// .to_top
document.querySelector('.to_top')?.addEventListener('click', (e) => {
  window.scrollTo({ top: 0, behavior: 'smooth' })
})
document.addEventListener('scroll', (e) => {
  if (window.scrollY > 1000) {
    document.querySelector('.to_top')?.classList.add('active')
  } else {
    document.querySelector('.to_top')?.classList.remove('active')
  }
})
