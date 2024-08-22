<x-layouts.account name="index">
  <div class="account-edit">
    <form class="account-edit__form">
      {{--  --}}
      <div class="account__title">Ваша личная информация</div>
      {{--  --}}
      <div class="account-edit__form-grid">
        {{--  --}}
        <x-form.input
          class="account-edit__form"
          id="email"
          type="email"
          label="E-mail"
          required
        />
        {{--  --}}
        <x-form.input
          class="account-edit__form"
          id="phone"
          type="tel"
          label="Телефон"
          required
        />

        {{--  --}}
        <x-form.input
          class="account-edit__form"
          id="last_name"
          label="Фамилия"
          required
        />
        {{--  --}}
        <x-form.input
          class="account-edit__form"
          id="first_name"
          label="Имя"
          required
        />
        {{--  --}}
        <x-form.input
          class="account-edit__form"
          id="middle_name"
          label="Отчество"
          required
        />
        {{--  --}}
        <x-form.input
          class="account-edit__form"
          id="birthday"
          type="date"
          label="Дата рождения"
          help="После сохранения дату рождения изменить нельзя"
        />
      </div>

      {{--  --}}
      <div class="account-edit__form-subtitle">
        Заполните, если хотите изменить пароль
      </div>
      {{--  --}}
      <div class="account-edit__form-group field-group">
        {{--  --}}
        <x-form.input
          class="account-edit__form"
          id="current_password"
          type="password"
          label="Старый пароль"
        />
        <div class="account-edit__form-grid">
          {{--  --}}
          <x-form.input
            class="account-edit__form"
            id="password"
            type="password"
            label="Новый пароль"
          />
          {{--  --}}
          <x-form.input
            class="account-edit__form"
            id="password_confirmation"
            type="password_confirmation"
            label="Повторите новый пароль"
          />
        </div>
      </div>

      <div class="account-edit__form-buttons">
        <div class="button account-edit__form-submit">Сохранить</div>
        <a class="button button-alt" href="/account-index">Отмена</a>
      </div>
    </form>
  </div>
</x-layouts.account>
