<x-layouts.account name="index">
  <div class="account-index">
    <div class="account-index__greeting">
      <p>
        Здравствуйте,
        <b>Иваааааааааааааааан,</b>
        добро пожаловать в ваш личный кабинет!
      </p>
      <div class="button button-alt button-mini">Выйти из аккаунта</div>
    </div>

    <div class="account-index__info account__card">
      <div class="account-index__title account__title">
        Ваша личная информация
      </div>

      <div class="account-index__info-line account__info-line">
        <div class="account-index__info-title account__info-title">
          Публичное имя
        </div>
        <div class="account-index__info-text account__info-text">Иван И.</div>
      </div>
      <div class="account-index__info-line account__info-line">
        <div class="account-index__info-title account__info-title">ФИО</div>
        <div class="account-index__info-text account__info-text">
          Иванов Иван Иванович
        </div>
      </div>
      <div class="account-index__info-line account__info-line">
        <div class="account-index__info-title account__info-title">Телефон</div>
        <div class="account-index__info-text account__info-text">
          +7 (999) 999-99-99
        </div>
      </div>
      <div class="account-index__info-line account__info-line">
        <div class="account-index__info-title account__info-title">E-mail:</div>
        <div class="account-index__info-text account__info-text">
          JkFkA@example.com
        </div>
      </div>
      <div class="account-index__info-line account__info-line">
        <div class="account-index__info-title account__info-title">
          Дата рождения
        </div>
        <div class="account-index__info-text account__info-text">
          01.01.1984
        </div>
      </div>
      <div class="account-index__info-line account__info-line">
        <div class="account-index__info-title account__info-title">Пол</div>
        <div class="account-index__info-text account__info-text">Мужской</div>
      </div>

      <a class="account-index__info-button button button-mini button-alt"
        href="/account-edit">
        Редактировать
      </a>
    </div>

    <x-account.loyalty-card>
      <a class="account-index__loyalty-button button button-alt" href="#">
        Подробнее
      </a>
    </x-account.loyalty-card>

    {{-- последние заказы --}}
    <div class="account-index__orders">
      <div class="account-index__orders-title account__title">
        Последние заказы
      </div>
      <div class="account-orders">
        @foreach (range(3, 1) as $item)
          <x-account.order :item="$item" />
        @endforeach
      </div>

      <a class="account-index__orders-button button button-alt" href="#">
        Посмотреть все
      </a>
    </div>
  </div>
</x-layouts.account>
