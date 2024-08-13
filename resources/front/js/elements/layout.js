// .to-top
document.querySelector('.to-top')?.addEventListener('click', (e) => {
  window.scrollTo({ top: 0, behavior: 'smooth' })
})
document.addEventListener('scroll', (e) => {
  if (window.scrollY > 1000) {
    document.querySelector('.to-top')?.classList.add('active')
  } else {
    document.querySelector('.to-top')?.classList.remove('active')
  }
})
