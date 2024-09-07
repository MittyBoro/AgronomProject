<div class="profile-address profile__card">
  <div class="profile-address__info-line profile__info-line">
    <div class="profile-address__info-title profile__info-title">ФИО</div>
    <div class="profile-address__info-text profile__info-text">
      Иванов Иван Иванович
    </div>
  </div>
  <div class="profile-address__info-line profile__info-line">
    <div class="profile-address__info-title profile__info-title">Телефон</div>
    <div class="profile-address__info-text profile__info-text">
      +7 (999) 999-99-99
    </div>
  </div>
  <div class="profile-address__info-line profile__info-line">
    <div class="profile-address__info-title profile__info-title">Email:</div>
    <div class="profile-address__info-text profile__info-text">
      JkFkA@example.com
    </div>
  </div>
  <div class="profile-address__info-line profile__info-line">
    <div class="profile-address__info-title profile__info-title">
      Населённый пункт
    </div>
    <div class="profile-address__info-text profile__info-text">Москва</div>
  </div>
  <div class="profile-address__info-buttons">
    <div
      @class([
        'button button-mini',
        'button-alt' => $item == 1,
        'button-alt--primary' => $item !== 1,
      ])
    >
      <x-main.icon src="icons/check.svg" />
      По умолчанию
    </div>
    <div class="button button-mini button-alt">
      <x-main.icon src="icons/edit.svg" />
    </div>
    <div class="button button-mini button-alt--danger">
      <x-main.icon src="icons/trash.svg" />
    </div>
  </div>
</div>
