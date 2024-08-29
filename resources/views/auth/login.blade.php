<x-layouts.auth title="Вход">
  <form method="POST" action="{{ route('login') }}">
    @csrf

    {{--  --}}
    <x-form.input
      class="auth__form"
      id="email"
      type="email"
      label="Email"
      :value="old('email')"
      required
      autofocus
      autocomplete="username"
    />

    {{--  --}}
    <x-form.input
      class="auth__form"
      id="current_password"
      type="password"
      label="Пароль"
      type="password"
      name="password"
      required
      autocomplete="current-password"
    />
    {{--  --}}
    <x-form.checkbox
      class="auth__form"
      id="remember"
      name="remember"
      type="password"
      label="Запомнить меня"
    />

    <div class="auth__form-buttons">
      <button class="button auth__button">Вход</button>
      @if (Route::has('password.request'))
        <a href="{{ route('password.request') }}" class="link">
          Забыли пароль?
        </a>
      @endif

      @if (Route::has('register'))
        <a href="{{ route('register') }}" class="link">Регистрация</a>
      @endif
    </div>
  </form>
</x-layouts.auth>
