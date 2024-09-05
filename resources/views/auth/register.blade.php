<x-layouts.auth title="Регистрация">
  <form
    method="POST"
    class="profile-edit__form-grid auth__form-grid"
    action="{{ route('register') }}"
    x-data="{ showAdditional: false }"
  >
    @csrf

    {{--  --}}
    <x-form.input
      class="profile-edit__form"
      id="first_name"
      label="Ваше имя"
      placeholder="Иван"
      minlength="2"
      value="{{ old('first_name') }}"
      required
    />
    {{--  --}}
    <x-form.input
      class="profile-edit__form"
      id="middle_name"
      label="Отчество"
      placeholder="Иванович"
      minlength="2"
      value="{{ old('middle_name') }}"
      x-show="showAdditional"
    />
    {{--  --}}
    <x-form.input
      class="profile-edit__form"
      id="last_name"
      label="Фамилия"
      placeholder="Иванов"
      minlength="2"
      value="{{ old('last_name') }}"
      x-show="showAdditional"
    />

    {{--  --}}
    <x-form.input
      class="profile-edit__form"
      id="email"
      type="email"
      label="Email"
      placeholder="mail@example.ru"
      value="{{ old('email') }}"
      required
    />
    {{--  --}}
    <x-form.input
      class="profile-edit__form"
      id="phone"
      type="tel"
      label="Телефон"
      value="{{ old('phone') }}"
      x-show="showAdditional"
      minlength="16"
    />
    {{--  --}}
    <x-form.input
      class="profile-edit__form"
      id="birthday"
      type="date"
      value="{{ old('birthday') }}"
      placeholder="ДД.MM.ГГГГ"
      label="Дата рождения"
      help="После сохранения дату рождения изменить нельзя"
      x-show="showAdditional"
    />

    <div
      class="profile-edit__form-more link"
      x-on:click="showAdditional = ! showAdditional"
    >
      <span x-show="! showAdditional">Заполнить</span>
      <span x-show="showAdditional">Скрыть</span>
      дополнительные поля
    </div>

    {{--  --}}
    <x-form.input
      class="profile-edit__form"
      id="password"
      type="password"
      label="Пароль"
      placeholder="..."
      required
      autocomplete="new-password"
    />
    {{--  --}}
    <x-form.input
      class="profile-edit__form"
      id="password_confirmation"
      placeholder="..."
      type="password"
      required
      label="Подтвердите пароль"
    />

    <div class="auth__form-buttons auth__form-buttons--register">
      <button class="button">Регистрация</button>
      {{--  --}}
      <x-form.checkbox class="checkout__privacy" id="privacy" required>
        Нажимая эту кнопку я соглашаюсь с
        <a class="link underline" target="_blank" href="/privacy">
          Политикой конфиденциальности
        </a>
      </x-form.checkbox>
    </div>
    <div
      class="auth__form-buttons"
      style="text-align: center; justify-content: center"
    >
      <a href="{{ route('login') }}" class="link">Уже есть аккаут?</a>
    </div>
  </form>
</x-layouts.auth>
