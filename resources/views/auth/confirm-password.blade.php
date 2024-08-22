<x-layouts.auth title="Подтверждение пароля">
  <form method="POST" action="{{ route('password.confirm') }}">
    @csrf

    <div class="info__message">
      Это защищенная область нашего сада. Пожалуйста, подтвердите свой пароль,
      прежде чем продолжить.
    </div>

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
      autofocus
    />

    <div class="auth__form-buttons">
      <button class="button auth__button">Подтвердить</button>
    </div>
  </form>
</x-layouts.auth>
