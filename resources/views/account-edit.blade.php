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
          label="E-mail *"
          type="email"
          id="email"
          required
        />
        {{--  --}}
        <x-form.input
          class="account-edit__form"
          label="Телефон"
          type="tel"
          id="phone"
          required
        />

        {{--  --}}
        <x-form.input
          class="account-edit__form"
          label="Фамилия *"
          required
          id="last_name"
        />
        {{--  --}}
        <x-form.input
          class="account-edit__form"
          label="Имя *"
          required
          id="first_name"
        />
        {{--  --}}
        <x-form.input
          class="account-edit__form"
          label="Отчество *"
          required
          id="patronymic"
        />
        {{--  --}}
        <x-form.input
          class="account-edit__form"
          label="Дата рождения *"
          help="После сохранения дату рождения изменить нельзя"
          type="date"
          id="birthday"
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
          label="Старый пароль"
          type="password"
          id="current_password"
        />
        <div class="account-edit__form-grid">
          {{--  --}}
          <x-form.input
            class="account-edit__form"
            label="Новый пароль"
            type="password"
            id="password"
          />
          {{--  --}}
          <x-form.input
            class="account-edit__form"
            label="Повторите новый пароль"
            type="password_confirmation"
            id="password_confirmation"
          />
        </div>
      </div>

      <div class="account-edit__form-buttons">
        <div class="button account-edit__form-submit">Сохранить</div>
        <a href="/account-index" class="button button-alt">Отмена</a>
      </div>
    </form>
  </div>
</x-layouts.account>
