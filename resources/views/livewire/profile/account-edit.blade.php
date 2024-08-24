<x-layouts.account name="index">
  <div class="profile-edit">
    <form class="profile-edit__form">
      {{--  --}}
      <div class="profile__title">Ваша личная информация</div>
      {{--  --}}
      <div class="profile-edit__form-grid">
        {{--  --}}
        <x-form.input
          class="profile-edit__form"
          id="email"
          type="email"
          label="E-mail"
          required
        />
        {{--  --}}
        <x-form.input
          class="profile-edit__form"
          id="phone"
          type="tel"
          label="Телефон"
          required
        />

        {{--  --}}
        <x-form.input
          class="profile-edit__form"
          id="last_name"
          label="Фамилия"
          required
        />
        {{--  --}}
        <x-form.input
          class="profile-edit__form"
          id="first_name"
          label="Имя"
          required
        />
        {{--  --}}
        <x-form.input
          class="profile-edit__form"
          id="middle_name"
          label="Отчество"
          required
        />
        {{--  --}}
        <x-form.input
          class="profile-edit__form"
          id="birthday"
          type="date"
          label="Дата рождения"
          help="После сохранения дату рождения изменить нельзя"
        />
      </div>

      {{--  --}}
      <div class="profile-edit__form-subtitle">
        Заполните, если хотите изменить пароль
      </div>
      {{--  --}}
      <div class="profile-edit__form-group field-group">
        {{--  --}}
        <x-form.input
          class="profile-edit__form"
          id="current_password"
          type="password"
          label="Старый пароль"
        />
        <div class="profile-edit__form-grid">
          {{--  --}}
          <x-form.input
            class="profile-edit__form"
            id="password"
            type="password"
            label="Новый пароль"
          />
          {{--  --}}
          <x-form.input
            class="profile-edit__form"
            id="password_confirmation"
            type="password_confirmation"
            label="Повторите новый пароль"
          />
        </div>
      </div>

      <div class="profile-edit__form-buttons">
        <div class="button profile-edit__form-submit">Сохранить</div>
        <a class="button button-alt" href="/profile-index">Отмена</a>
      </div>
    </form>
  </div>
</x-layouts.account>
