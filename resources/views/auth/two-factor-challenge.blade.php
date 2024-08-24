<x-layouts.auth title="Подтверждение доступа">
  <div x-data="{ recovery: false }">
    <div class="mb-4 text-sm text-gray-600" x-show="! recovery">
      Подтвердите доступ к своей учетной записи, введя код аутентификации,
      предоставленный вашим приложением-аутентификатором.
    </div>

    <div class="mb-4 text-sm text-gray-600" x-cloak x-show="recovery">
      Подтвердите доступ к своей учетной записи, введя один из ваших кодов
      экстренного восстановления.
    </div>

    <form method="POST" action="{{ route('two-factor.login') }}">
      @csrf

      <x-form.input
        class="profile-edit__form"
        id="code"
        type="text"
        label="Код"
        x-ref="code"
        x-show="! recovery"
        autofocus
        autocomplete="one-time-code"
        inputmode="numeric"
      />

      <x-form.input
        class="profile-edit__form"
        x-cloak
        x-show="recovery"
        id="code"
        type="text"
        label="Код"
        x-ref="code"
        x-show="! recovery"
        autofocus
        autocomplete="one-time-code"
        inputmode="numeric"
        x-ref="recovery_code"
        autocomplete="one-time-code"
      />

      <div class="auth__form-buttons">
        <button
          type="button"
          class="button button-alt"
          x-show="! recovery"
          x-on:click="
            recovery = true
            $nextTick(() => {
              $refs.recovery_code.focus()
            })
          "
        >
          Используйте код восстановления
        </button>

        <button
          type="button"
          class="button button-alt"
          x-cloak
          x-show="recovery"
          x-on:click="
            recovery = false
            $nextTick(() => {
              $refs.code.focus()
            })
          "
        >
          Используйте код аутентификации
        </button>

        <button class="button">Войти</button>
      </div>
    </form>
  </div>
</x-layouts.auth>
