<div class="account-address account__card">
  <div class="account-address__info-line account__info-line">
    <div class="account-address__info-title account__info-title">ФИО</div>
    <div class="account-address__info-text account__info-text">
      Иванов Иван Иванович
    </div>
  </div>
  <div class="account-address__info-line account__info-line">
    <div class="account-address__info-title account__info-title">Телефон</div>
    <div class="account-address__info-text account__info-text">
      +7 (999) 999-99-99
    </div>
  </div>
  <div class="account-address__info-line account__info-line">
    <div class="account-address__info-title account__info-title">E-mail:</div>
    <div class="account-address__info-text account__info-text">
      JkFkA@example.com
    </div>
  </div>
  <div class="account-address__info-line account__info-line">
    <div class="account-address__info-title account__info-title">
      Населённый пункт
    </div>
    <div class="account-address__info-text account__info-text">Москва</div>
  </div>
  <div class="account-address__info-buttons">
    <div
      @class(['button button-mini', 'button-alt' => $item == 1, 'button-alt--primary' => $item !== 1])
    >
      <x-icon src="icons/check.svg" />
      По умолчанию
    </div>
    <div class="button button-mini button-alt">
      <x-icon src="icons/edit.svg" />
    </div>
    <div class="button button-mini button-alt--danger">
      <x-icon src="icons/trash.svg" />
    </div>
  </div>
</div>
