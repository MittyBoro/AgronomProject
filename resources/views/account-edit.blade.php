<x-layouts.account name="index">
  <div class="account-edit">
    <form class="account-edit__form">
      {{--  --}}
      <div class="account__title">Ваша личная информация</div>
      {{--  --}}
      <div class="account-edit__form-grid">
        {{--  --}}
        <div class="account-edit__form-group field-group">
          <label for="last_name" class="account-edit__form-label field-label">
            Фамилия *
          </label>
          <input
            type="text"
            id="last_name"
            class="account-edit__form-input field-input"
            required
          />
        </div>
        {{--  --}}
        <div class="account-edit__form-group field-group">
          <label for="first_name" class="account-edit__form-label field-label">
            Имя *
          </label>
          <input
            type="text"
            id="first_name"
            class="account-edit__form-input field-input"
            required
          />
        </div>
        {{--  --}}
        <div class="account-edit__form-group field-group">
          <label for="patronymic" class="account-edit__form-label field-label">
            Отчество *
          </label>
          <input
            type="text"
            id="patronymic"
            class="account-edit__form-input field-input"
            required
          />
        </div>

        {{--  --}}
        <div class="account-edit__form-group field-group">
          <label for="birthday" class="account-edit__form-label field-label">
            Дата рождения *
          </label>
          <input
            type="text"
            id="birthday"
            class="account-edit__form-input field-input"
            required
          />
        </div>
      </div>

      {{--  --}}
      <div class="account-edit__form-grid">
        {{--  --}}
        <div class="account-edit__form-group field-group">
          <label for="email" class="account-edit__form-label field-label">
            E-mail *
          </label>
          <input
            type="email"
            id="email"
            class="account-edit__form-input field-input"
            required
          />
        </div>
        {{--  --}}
        <div class="account-edit__form-group field-group">
          <label for="phone" class="account-edit__form-label field-label">
            Телефон
          </label>
          <input
            type="tel"
            id="phone"
            class="account-edit__form-input field-input"
            required
          />
        </div>
      </div>

      {{--  --}}
      <div class="account-edit__form-subtitle">
        Заполните, если хотите изменить пароль
      </div>
      {{--  --}}
      <div class="account-edit__form-group field-group">
        <label
          for="current_password"
          class="account-edit__form-label field-label"
        >
          Старый пароль
        </label>
        <input
          type="password"
          id="current_password"
          class="account-edit__form-input field-input"
          required
        />
      </div>
      {{--  --}}
      <div class="account-edit__form-grid">
        {{--  --}}
        <div class="account-edit__form-group field-group">
          <label for="password" class="account-edit__form-label field-label">
            Новый пароль
          </label>
          <input
            type="password"
            id="password"
            class="account-edit__form-input field-input"
            required
          />
        </div>
        {{--  --}}
        <div class="account-edit__form-group field-group">
          <label
            for="password_confirmation"
            class="account-edit__form-label field-label"
          >
            Повторите новый пароль
          </label>
          <input
            type="password"
            id="password_confirmation"
            class="account-edit__form-input field-input"
            required
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
