<header class="header">
  <div class="header__container container">
    <a class="header__logo" href="/" wire:navigate>
      <picture>
        <source
          srcset="{{ Vite::front('images/logo.svg') }}"
          media="(max-width: 360px)"
        />
        <img
          class="header__logo-image"
          src="{{ Vite::front('images/logo-big.svg') }}"
          alt="АгрономСити"
        />
      </picture>
    </a>
    <nav class="header__nav">
      <ul class="header__nav-list">
        <li class="header__nav-item">
          <a class="header__nav-link link" href="/catalog" wire:navigate>
            Каталог
          </a>
        </li>
        <li class="header__nav-item">
          <a class="header__nav-link link" href="/about" wire:navigate>О нас</a>
        </li>
        <li class="header__nav-item">
          <a class="header__nav-link link" href="/delivery" wire:navigate>
            Доставка
          </a>
        </li>
        <li class="header__nav-item">
          <a class="header__nav-link link" href="/payment" wire:navigate>
            Оплата
          </a>
        </li>
        <li class="header__nav-item">
          <a class="header__nav-link link" href="/contacts" wire:navigate>
            Контакты
          </a>
        </li>
      </ul>
    </nav>
    <div class="header__search" data-popup=".popup__search">
      <input
        class="header__search-input field-input"
        type="text"
        placeholder="Что вы ищете?"
        readonly
      />
      <x-main.icon class="header__search-icon link" src="icons/search.svg" />
    </div>
    <div class="header__icons">
      {{-- избранное --}}
      <a class="header__icon link" href="/wishlist" wire:navigate>
        <x-main.icon src="icons/heart.svg" />
        <livewire:components.wishlist-count
          class="header__icon--badge"
          list="wishlist"
        />
      </a>
      {{-- корзина --}}
      <a class="header__icon link" href="/cart" wire:navigate>
        <x-main.icon src="icons/cart.svg" />
        <livewire:components.cart-count
          class="header__icon--badge"
          list="cart"
        />
      </a>
      {{-- личный кабинет --}}
      <div class="header__dropdown header__icon">
        <span class="header__icon" ondblclick="Livewire.navigate('/login')">
          @auth
            <x-main.icon src="icons/face.svg" />
          @endauth

          @guest
            <x-main.icon src="icons/user.svg" />
          @endguest
        </span>

        <div class="header__dropdown-list">
          @auth
            <a
              class="header__dropdown-item link"
              href="{{ route('profile.index') }}"
              rel="nofollow"
              wire:navigate
            >
              <x-main.icon src="icons/user.svg" />
              <span>{{ Auth::user()->name }}</span>
            </a>
            <a
              class="header__dropdown-item link"
              href="{{ route('register') }}"
              rel="nofollow"
              wire:navigate
            >
              <x-main.icon src="icons/box.svg" />
              <span>Заказы</span>
            </a>
            <a
              class="header__dropdown-item link"
              href="{{ route('register') }}"
              rel="nofollow"
              wire:navigate
            >
              <x-main.icon src="icons/card.svg" />
              <span>Бонусы</span>
            </a>
            <a
              class="header__dropdown-item link"
              href="{{ route('register') }}"
              rel="nofollow"
              wire:navigate
            >
              <x-main.icon src="icons/settings.svg" />
              <span>Настройки</span>
            </a>
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button class="header__dropdown-item link">
                <x-main.icon src="icons/logout.svg" />
                <span>Выход</span>
              </button>
            </form>
          @endauth

          @guest
            <a
              class="header__dropdown-item link"
              href="{{ route('register') }}"
              rel="nofollow"
              wire:navigate
            >
              <x-main.icon src="icons/sign_up.svg" />
              <span>Регистрация</span>
            </a>
            <a
              class="header__dropdown-item link"
              href="{{ route('login') }}"
              rel="nofollow"
              wire:navigate
            >
              <span style="transform: translateX(-2px)">
                <x-main.icon src="icons/sign_in.svg" />
              </span>
              <span>Вход</span>
            </a>
          @endguest
        </div>
      </div>
      <div class="header__icon header__icon-menu" data-popup=".popup__menu">
        <x-main.icon src="icons/menu.svg" />
      </div>
    </div>
  </div>
</header>
