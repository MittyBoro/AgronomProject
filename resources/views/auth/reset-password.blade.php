<x-layouts.auth title="Востановление пароля">
  <form method="POST" action="{{ route('password.update') }}">
    @csrf

    <input type="hidden" name="token" value="{{ $request->route('token') }}" />

    <x-form.input
      class="auth__form"
      id="email"
      type="email"
      label="Email"
      :value="old('email', $request->email)"
      required
      readonly
      autocomplete="username"
    />

    {{--  --}}
    <x-form.input
      class="profile-edit__form"
      id="password"
      type="password"
      label="Новый пароль"
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

    {{--  --}}
    <div class="auth__form-buttons">
      <button class="button auth__button">Восстановить</button>
    </div>
  </form>
</x-layouts.auth>
