@use('Laravel\Fortify\Fortify')
@session('status')
  <div class="success__message">
    {{
      match ($value) {
        Fortify::PASSWORD_UPDATED => 'Пароль изменен',
        Fortify::PROFILE_INFORMATION_UPDATED => 'Профиль обновлен',
        Fortify::RECOVERY_CODES_GENERATED => 'Коды восстановления сгенерированы',
        Fortify::TWO_FACTOR_AUTHENTICATION_CONFIRMED => 'Двухфакторная аутентификация подтверждена',
        Fortify::TWO_FACTOR_AUTHENTICATION_DISABLED => 'Двухфакторная аутентификация отключена',
        Fortify::TWO_FACTOR_AUTHENTICATION_ENABLED => 'Двухфакторная аутентификация включена',
        Fortify::VERIFICATION_LINK_SENT => 'Ссылка для верификации отправлена',
        default => session('status'),
      }
    }}
  </div>
@endsession
