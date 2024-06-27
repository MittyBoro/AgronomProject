<x-layouts.account name="loyalty">
  <x-slot:top>
    <x-breadcrumbs
      :list="[['Мой профиль', '/account-index'], ['Бонусы', null]]"
    />
  </x-slot>
  <div class="account-loyalty">
    {{-- account-card --}}
    <div class="account-card__container">
      <div class="account-card">
        <div class="account-card__logo">
          <img
            src="{{ vite_asset('images/logo-big.svg') }}"
            alt="АгрономСити"
            class="account-card__logo-image"
          />
          <div class="account-card__logo-text">бонусная карта</div>
        </div>
        <div class="account-card__count">
          <div class="account-card__count-value primary">3%</div>
          <div class="account-card__count-label">от покупки</div>
        </div>
        <div class="account-card__count">
          <div class="account-card__count-value primary">2 000</div>
          <div class="account-card__count-label">бонусов</div>
        </div>
        <div class="account-card__number">123 456 789</div>
      </div>
    </div>

    <div class="account-loyalty__progress">
      <div class="account-loyalty__progress-title">1 уровень</div>
      <div class="account-loyalty__progress-bar" style="--progress: 30%"></div>
      <div>
        До повышения уровня осталось
        <span>15 000 ₽</span>
      </div>
    </div>
    <div class="account-card__link">
      <a href="#" class="link">Условиях использования бонусной карты</a>
    </div>
  </div>
  <x-slot:bottom>
    <x-loyalty-system />
  </x-slot>
</x-layouts.account>
