{{-- mobile bar --}}
<nav class="mobile-nav">
  <div class="mobile-nav__container container">
    <a class="mobile-nav__link link" href="/" wire:navigate>
      <x-main.icon class="mobile-nav__icon" src="icons/logo.svg" />
      <span>Главная</span>
    </a>
    <a class="mobile-nav__link link" href="/catalog" wire:navigate>
      <x-main.icon class="mobile-nav__icon" src="icons/catalog.svg" />
      <span>Каталог</span>
    </a>
    <a class="mobile-nav__link link" href="/" wire:navigate>
      <x-main.icon class="mobile-nav__icon" src="icons/heart.svg" />
      <span>Избранное</span>
    </a>
    <a class="mobile-nav__link link" href="/" wire:navigate>
      <x-main.icon class="mobile-nav__icon" src="icons/user.svg" />
      <span>Профиль</span>
    </a>
    <a class="mobile-nav__link link" href="/cart" wire:navigate>
      <x-main.icon class="mobile-nav__icon" src="icons/cart.svg" />
      <span>Корзина</span>
    </a>
  </div>
</nav>
