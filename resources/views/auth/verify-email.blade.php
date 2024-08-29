<x-layouts.auth title="Подтверждение почты">
  <div class="auth__form">
    <div class="info__message prose">
      @php
        $inbox = inbox_url(Auth::user()->email);
      @endphp

      <p>
        Для продолжения подтвердите свой email, перейдя по ссылке, отправленной

        @if ($inbox)
          <a
            href="{{ $inbox }}"
            target="_blank"
            class="color-link"
            rel="nofollow"
          >
            на вашу почту
          </a>
        @else
          на вашу почту
        @endif
        (оно может попасть в папку «Спам»). Если письмо не пришло, мы можем
        отправить новое.
      </p>
    </div>

    <div class="auth__form-buttons-grid">
      {{--  --}}
      <form
        method="POST"
        сlass="auth__form-buttons"
        action="{{ route('verification.send') }}"
      >
        @csrf

        <button class="button" type="submit">Отправить повторно</button>
      </form>
      {{--  --}}
      <a
        href="{{ route('profile.edit') }}"
        class="button button-alt"
        wire:navigate
      >
        Редактировать профиль
      </a>
      {{--  --}}
      <form
        method="POST"
        action="{{ route('logout') }}"
        сlass="auth__form-buttons"
      >
        @csrf
        <button type="submit" class="button button-alt">Выйти</button>
      </form>
    </div>
  </div>
</x-layouts.auth>
