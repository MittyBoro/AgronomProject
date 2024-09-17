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
    <a class="mobile-nav__link link" href="/wishlist" wire:navigate>
      <x-main.icon class="mobile-nav__icon" src="icons/heart.svg" />
      <span>Избранное</span>
      <livewire:components.wishlist-count
        class="mobile-nav__badge badge"
        list="wishlist"
      />
    </a>
    <a class="mobile-nav__link link" href="/cart" wire:navigate>
      <x-main.icon class="mobile-nav__icon" src="icons/cart.svg" />
      <span>Корзина</span>
      <livewire:components.cart-count
        class="mobile-nav__badge badge"
        list="cart"
      />
    </a>
    @auth
      <a class="mobile-nav__link link" href="/profile" wire:navigate>
        <x-main.icon class="mobile-nav__icon" src="icons/user.svg" />
        <span>
          Профиль
          <livewire:components.user-balance
            class="mobile-nav__badge badge"
            mini
          />
        </span>
      </a>
    @endauth

    @guest
      <div class="mobile-nav__dropdown dropdown mobile-nav__link" onclick="">
        <x-main.icon class="mobile-nav__icon" src="icons/user.svg" />
        <span>Профиль</span>
        <div class="mobile-nav__dropdown-list dropdown-list">
          <a
            class="dropdown-item link"
            href="{{ route('register') }}"
            rel="nofollow"
            wire:navigate
          >
            <x-main.icon src="icons/sign_up.svg" />
            <span>Регистрация</span>
          </a>
          <a
            class="dropdown-item link"
            href="{{ route('login') }}"
            rel="nofollow"
            wire:navigate
          >
            <span style="transform: translateX(-2px)">
              <x-main.icon src="icons/sign_in.svg" />
            </span>
            <span>Вход</span>
          </a>
        </div>
      </div>
    @endguest
  </div>
</nav>
