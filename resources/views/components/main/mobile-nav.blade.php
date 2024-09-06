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
      <a class="mobile-nav__link link" href="/" wire:navigate>
        <x-main.icon class="mobile-nav__icon" src="icons/user.svg" />
        <span>
          Профиль
          <livewire:components.user-balance class="mobile-nav__badge badge" />
        </span>
      </a>
    @endauth

    @guest
      <a class="mobile-nav__link link" href="/login" wire:navigate>
        <x-main.icon class="mobile-nav__icon" src="icons/user.svg" />
        <span>Вход</span>
      </a>
    @endguest
  </div>
</nav>
