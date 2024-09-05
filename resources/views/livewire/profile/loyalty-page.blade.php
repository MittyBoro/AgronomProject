<div>
  <div class="profile-loyalty">
    {{--  --}}
    <div class="loyalty-card__wrapper">
      <livewire:components.loyalty-card />
      <div class="loyalty-card__link">
        <a class="link" href="#">Условиях использования бонусной карты</a>
      </div>
    </div>

    {{--  --}}
    <div class="profile-loyalty__info">
      <div class="profile-loyalty__info-text">
        Копите бонусы и оплачивайте
        <br />
        <b class="primary">до {{ config('shop.max_spend_bonuses') }}%</b>
        от стоимости заказа
      </div>
      <div class="profile-loyalty__progress">
        <div class="profile-loyalty__progress-title">
          У вас {{ $user->loyalty?->title }}
        </div>
        <div
          class="profile-loyalty__progress-bar"
          style="--progress: {{ $toNextLevelPercent }}%"
        ></div>

        @if ($toNextLevel >= 0)
          <div>
            До повышения уровня осталось заказать на
            <b>{{ price_formatter($toNextLevel) }} ₽</b>
          </div>
        @else
          <div>Вы достигли максимального уровня!</div>
        @endif
      </div>
    </div>
  </div>
  <x-slot name="bottom">
    <livewire:lists.loyalty-list />
  </x-slot>
</div>
