<x-layouts.account name="index">
  <div class="account-index">
    <div class="account-index__greeting">
      <p>
        Здравствуйте,
        <b>Иван,</b>
        добро пожаловать в ваш личный кабинет!
      </p>
      <div class="button button-alt button-mini">Выйти из аккаунта</div>
    </div>

    <div class="account-index__info account__card">
      <div class="account-index__title account__title">
        Ваша личная информация
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

      <a
        href="/account-edit"
        class="account-index__info-button button button-mini button-alt"
      >
        Редактировать
      </a>
    </div>

    <x-account.loyalty-card>
      <a href="#" class="account-index__loyalty-button button button-alt">
        Подробнее
      </a>
    </x-account.loyalty-card>
  </div>
</x-layouts.account>
