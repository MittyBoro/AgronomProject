  <header class="header">
    <div class="header__container container">
      <a class="header__logo" href="/" wire:navigate>
        <picture>
          <source srcset="{{ Vite::front('images/logo.svg') }}"
            media="(max-width: 360px)" />
          <img class="header__logo-image"
            src="{{ Vite::front('images/logo-big.svg') }}" alt="АгрономСити" />
        </picture>
      </a>
      <nav class="header__nav">
        <ul class="header__nav-list">
          <li class="header__nav-item">
            <a class="header__nav-link link" href="/catalog"
              wire:navigate>Каталог</a>
          </li>
          <li class="header__nav-item">
            <a class="header__nav-link link" href="/about"
              wire:navigate>О нас</a>
          </li>
          <li class="header__nav-item">
            <a class="header__nav-link link" href="/delivery"
              wire:navigate>Доставка</a>
          </li>
          <li class="header__nav-item">
            <a class="header__nav-link link" href="/payment"
              wire:navigate>Оплата</a>
          </li>
          <li class="header__nav-item">
            <a class="header__nav-link link" href="/contacts"
              wire:navigate>Контакты</a>
          </li>
        </ul>
      </nav>
      <div class="header__search" data-popup=".popup__search">
        <input class="header__search-input field-input" type="text"
          placeholder="Что вы ищете?" readonly />
        <x-main.icon class="header__search-icon link" src="icons/search.svg" />
      </div>
      <div class="header__icons">
        <a class="header__icon link" href="/account-favorites" wire:navigate>
          <x-main.icon src="icons/heart.svg" />
        </a>
        <a class="header__icon link" href="/cart" wire:navigate>
          <x-main.icon src="icons/cart.svg" />
        </a>
        <a class="header__icon link" href="/account-index" wire:navigate>
          <x-main.icon src="icons/user.svg" />
        </a>
        <div class="header__icon header__icon-menu" data-popup=".popup__menu">
          <x-main.icon src="icons/menu.svg" />
        </div>
      </div>
    </div>
  </header>
