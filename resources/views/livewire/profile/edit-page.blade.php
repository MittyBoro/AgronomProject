<div class="profile-edit">
  <x-form.validation-errors />
  <x-form.session-status />

  <form
    action="{{ route('user-profile-information.update') }}"
    method="POST"
    class="profile-edit__form"
  >
    @csrf
    @method('PUT')

    {{--  --}}
    <div class="profile__title">Ваша личная информация</div>
    {{--  --}}
    <x-form.input
      class="profile-edit__form"
      id="name"
      label="Отображаемое имя"
      help="Отображается на сайте, например в отзывах"
      value="{{ old('name', $user->name) }}"
      required
    />
    {{--  --}}
    <div class="profile-edit__form-grid">
      {{--  --}}
      <x-form.input
        class="profile-edit__form"
        id="email"
        type="email"
        label="Email"
        value="{{ old('email', $user->email) }}"
        required
      />
      {{--  --}}
      <x-form.input
        class="profile-edit__form"
        id="phone"
        type="tel"
        label="Телефон"
        placeholder="+7 ___ ___ __ __"
        value="{{ old('phone', $user->phone) }}"
        x-mask="+7 999 999 99 99"
        x-on:input="event.target.value.startsWith('+7 8') && (event.target.value = event.target.value.replace('+7 8', '+7'))"
        minlength="16"
      />

      {{--  --}}
      <x-form.input
        class="profile-edit__form"
        id="last_name"
        label="Фамилия"
        value="{{ old('last_name', $user->last_name) }}"
        required
      />
      {{--  --}}
      <x-form.input
        class="profile-edit__form"
        id="first_name"
        label="Имя"
        value="{{ old('first_name', $user->first_name) }}"
        required
      />
      {{--  --}}
      <x-form.input
        class="profile-edit__form"
        id="middle_name"
        label="Отчество"
        value="{{ old('middle_name', $user->middle_name) }}"
        required
      />
      {{--  --}}
      <x-form.input
        class="profile-edit__form"
        id="birthday"
        type="date"
        label="Дата рождения"
        help="После сохранения дату рождения изменить нельзя"
        value="{{ old('birthday', $user->birthday?->format('Y-m-d')) }}"
        :readonly="!!$user->birthday"
      />
    </div>
    <div class="profile-edit__form-buttons">
      <button class="button profile-edit__form-submit">Сохранить</button>
      <a class="button button-alt" href="/profile">Отмена</a>
    </div>
  </form>

  <form
    action="{{ route('user-password.update') }}"
    method="POST"
    class="profile-edit__form"
  >
    @csrf
    @method('PUT')
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
      <button class="button button-alt profile-edit__form-submit">
        Сохранить
      </button>
    </div>
  </form>
</div>
