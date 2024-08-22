<x-layouts.auth title="Подтверждение почты">
  <div class="auth__form">
    <div class="info__message">
      Прежде чем продолжить, не могли бы вы подтвердить свой адрес электронной
      почты, нажав на ссылку, которую мы только что отправили на ваш E-mail?
      Если вы не получили письмо — для начала проверьте папку «Спам», но мы с
      радостью можем отправить вам другое.
    </div>

    @if (session('status') == 'verification-link-sent')
      <div class="success__message">
        Новая ссылка для подтверждения была отправлена ​​на адрес электронной
        почты, указанный вами в настройках профиля.
      </div>
    @endif

    <form
      method="POST"
      сlass="auth__form-buttons"
      action="{{ route('verification.send') }}"
    >
      @csrf

      <button class="button" type="submit">Отправить повторно</button>
    </form>

    <div сlass="auth__form-buttons">
      <a href="{{ route('profile.show') }}" class="button button-alt">
        Редактировать профиль
      </a>
    </div>

    <form
      method="POST"
      action="{{ route('logout') }}"
      сlass="auth__form-buttons"
    >
      @csrf
      <button type="submit" class="button button-alt">Выйти</button>
    </form>
  </div>
</x-layouts.auth>
