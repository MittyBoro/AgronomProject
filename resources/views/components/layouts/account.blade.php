@props([
  'top',
  'bottom',
])
<x-layouts.main body_name="account">
  {{--  --}}
  {{ $top ?? '' }}

  {{-- account --}}
  <section class="account account__section">
    <div class="account__container container">
      <aside class="account-sidebar sidebar">
        <ul class="account-sidebar__list sidebar__list">
          <li @class(['active' => $attributes['name'] === 'index'])>
            <a href="/account-index" class="link">Мой профиль</a>
          </li>
          <li @class(['active' => $attributes['name'] === 'favorites'])>
            <a href="/account-favorites" class="link">
              Избранное
              <span class="badge">8</span>
            </a>
          </li>
          <li @class(['active' => $attributes['name'] === 'orders'])>
            <a href="/account-orders" class="link">История заказов</a>
          </li>
          <li @class(['active' => $attributes['name'] === 'addresses'])>
            <a href="/account-addresses" class="link">Адреса</a>
          </li>
          <li @class(['active' => $attributes['name'] === 'loyalty'])>
            <a href="/account-loyalty" class="link">
              Бонусы
              <span class="badge">12</span>
            </a>
          </li>
        </ul>
      </aside>
      <div class="account__content">
        {{ $slot }}
      </div>
    </div>
  </section>

  {{--  --}}
  {{ $bottom ?? '' }}
</x-layouts.main>
