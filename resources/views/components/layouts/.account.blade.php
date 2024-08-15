<x-layouts.main body_name="account">
  {{-- account --}}
  <section class="account-header account-header__section account">
    <div class="account-header__container container">
      <a
        href="/account-index"
        @class([
          'account-header__link',
          'active' => $attributes['name'] === 'index',
        ])
      >
        <x-main.icon src="icons/user.svg" />
        <span>Личный кабинет</span>
      </a>
      <a
        href="/account-favorites"
        @class([
          'account-header__link',
          'active' => $attributes['name'] === 'favorites',
        ])
      >
        <x-main.icon src="icons/heart.svg" />
        <span>Избранное</span>
        <span class="badge">8</span>
      </a>
      <a
        href="/account-orders"
        @class([
          'account-header__link',
          'active' => $attributes['name'] === 'orders',
        ])
      >
        <x-main.icon src="icons/list.svg" />
        <span>История заказов</span>
      </a>
      <a
        href="/account-addresses"
        @class([
          'account-header__link',
          'active' => $attributes['name'] === 'addresses',
        ])
      >
        <x-main.icon src="icons/location.svg" />
        <span>Адреса</span>
      </a>
      <a
        href="/account-loyalty"
        @class([
          'account-header__link',
          'active' => $attributes['name'] === 'loyalty',
        ])
      >
        <x-main.icon src="icons/card.svg" />
        <span>Бонусы</span>
        <span class="badge">12</span>
      </a>
    </div>
  </section>

  <section class="account-body account-body__section account">
    <div class="container">
      {{ $slot }}
    </div>
  </section>

  {{ $bottom ?? '' }}
</x-layouts.main>
