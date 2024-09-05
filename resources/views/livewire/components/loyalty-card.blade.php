<div class="loyalty-card">
  <div class="loyalty-card__logo">
    <img
      class="loyalty-card__logo-image"
      src="{{ Vite::front('images/logo-big.svg') }}"
      alt="АгрономСити"
    />
    <div class="loyalty-card__logo-text">бонусная карта</div>
  </div>
  <div class="loyalty-card__count">
    <div class="loyalty-card__count-value primary">
      {{ $user->loyalty?->percentage ?? 0 }}%
    </div>
    <div class="loyalty-card__count-label">от покупки</div>
  </div>
  <div class="loyalty-card__count">
    <div class="loyalty-card__count-value primary">
      {{ price_formatter($user->balance) }}
    </div>
    <div class="loyalty-card__count-label">
      {{ sklonenie($user->balance, ['бонус', 'бонуса', 'бонусов']) }}
    </div>
  </div>
  <div class="loyalty-card__number">{{ $id }}</div>
</div>
