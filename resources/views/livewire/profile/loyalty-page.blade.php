<div>
  <div class="profile-loyalty">
    {{--  --}}
    <x-profile.loyalty-card>
      <a class="link" href="#">Условиях использования бонусной карты</a>
    </x-profile.loyalty-card>

    {{--  --}}
    <div class="profile-loyalty__info">
      <div class="profile-loyalty__info-text">
        Копите бонусы и оплачивайте
        <br />
        <b class="primary">до 50%</b>
        от стоимости заказа
      </div>
      <div class="profile-loyalty__progress">
        <div class="profile-loyalty__progress-title">У вас 1 уровень</div>
        <div
          class="profile-loyalty__progress-bar"
          style="--progress: 30%"
        ></div>
        <div>
          До повышения уровня осталось
          <span>15 000 ₽</span>
        </div>
      </div>
    </div>
  </div>
  <x-slot name="bottom">
    <livewire:lists.loyalty-list />
  </x-slot>
</div>
