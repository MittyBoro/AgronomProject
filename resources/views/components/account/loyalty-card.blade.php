<div class="loyalty-card__wrapper">
  <div class="loyalty-card">
    <div class="loyalty-card__logo">
      <img
        src="{{ vite_asset('images/logo-big.svg') }}"
        alt="АгрономСити"
        class="loyalty-card__logo-image"
      />
      <div class="loyalty-card__logo-text">бонусная карта</div>
    </div>
    <div class="loyalty-card__count">
      <div class="loyalty-card__count-value primary">3%</div>
      <div class="loyalty-card__count-label">от покупки</div>
    </div>
    <div class="loyalty-card__count">
      <div class="loyalty-card__count-value primary">2 000</div>
      <div class="loyalty-card__count-label">бонусов</div>
    </div>
    <div class="loyalty-card__number">123 456 789</div>
  </div>
  <div class="loyalty-card__link">
    {{ $slot }}
  </div>
</div>
