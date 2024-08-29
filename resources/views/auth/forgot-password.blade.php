<x-layouts.auth title="Востановление пароля">
  <x-slot name="info">
    Забыли пароль? Нет проблем. Просто введите свою электронную почту, и мы
    вышлем вам ссылку для сброса пароля, которая позволит вам выбрать новый
    пароль.
  </x-slot>

  <form method="POST" action="{{ route('password.email') }}">
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
    <div class="auth__form-buttons">
      <button class="button auth__button">Отправить</button>
      <a href="{{ route('login') }}" class="link" style="margin: 10px auto 0">
        Вспомнил пароль, войти
      </a>
    </div>
  </form>
</x-layouts.auth>
