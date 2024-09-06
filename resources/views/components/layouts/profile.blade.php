@php
  SEOMeta::setTitle($title ?? 'Личный кабинет');
  SEOMeta::addMeta('robots', 'noindex, nofollow');
@endphp

<x-layouts.app body_name="account">
  {{-- account --}}
  <section class="profile-header profile-header__section account">
    <div class="profile-header__container container">
      {{--  --}}
      <a
        href="/profile"
        @class([
          'profile-header__link',
          'active' =>
            request()->routeIs('profile.index') || request()->routeIs('profile.edit'),
        ])
        wire:navigate
      >
        <x-main.icon src="icons/user.svg" />
        <span>Личный кабинет</span>
      </a>

      {{--  --}}
      <a
        href="/wishlist"
        @class(['profile-header__link', 'active' => request()->routeIs('wishlist')])
        wire:navigate
      >
        <x-main.icon src="icons/heart.svg" />
        <span>Избранное</span>

        <livewire:components.wishlist-count class="badge" list="wishlist" />
      </a>

      {{--  --}}
      <a
        href="/profile/orders"
        @class([
          'profile-header__link',
          'active' =>
            request()->routeIs('profile.orders') || request()->routeIs('profile.order'),
        ])
        wire:navigate
      >
        <x-main.icon src="icons/list.svg" />
        <span>История заказов</span>
      </a>

      {{--  --}}
      <a
        href="/profile/loyalty"
        @class([
          'profile-header__link',
          'active' => request()->routeIs('profile.loyalty'),
        ])
        wire:navigate
      >
        <x-main.icon src="icons/card.svg" />
        <span>Бонусы</span>
        <span class="badge">
          {{ price_formatter(Auth::user()?->balance) }}
        </span>
      </a>
    </div>
  </section>

  <section class="profile-body profile-body__section account">
    <div class="container">
      {{ $slot }}
    </div>
  </section>

  {{ $bottom ?? '' }}
</x-layouts.app>
