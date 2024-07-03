<x-layouts.account name="loyalty">
  <div class="account-loyalty">
    {{--  --}}
    <x-account.loyalty-card>
      <a class="link" href="#">Условиях использования бонусной карты</a>
    </x-account.loyalty-card>

    {{--  --}}
    <div class="account-loyalty__info">
      <div class="account-loyalty__info-text">
        Копите бонусы и оплачивайте
        <br />
        <b class="primary">до 50%</b>
        от стоимости заказа
      </div>
      <div class="account-loyalty__progress">
        <div class="account-loyalty__progress-title">У вас 1 уровень</div>
        <div class="account-loyalty__progress-bar" style="--progress: 30%"></div>
        <div>
          До повышения уровня осталось
          <span>15 000 ₽</span>
        </div>
      </div>
    </div>
  </div>
  <x-slot:bottom>
    <x-a.loyalty-system />
  </x-slot>
</x-layouts.account>
