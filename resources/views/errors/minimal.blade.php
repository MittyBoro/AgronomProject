<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>@yield('title')</title>

    @vite(config('app.resources.front') . '/scss/app.scss')
  </head>
  <body>
    <main class="simple-page">
      {{-- article --}}
      <section class="page__section error-page_section">
        <div class="page__container container">
          <div class="head-row">
            <div class="head-row__pretitle">
              Ошибка
              @yield('code')
            </div>
            <div class="head-row__title">
              <h1>@yield('title')</h1>
            </div>
          </div>

          <div class="prose">
            <p class="error-message">@yield('message')</p>
          </div>

          @if (isset($exception) && $exception->getStatusCode() < 429)
            <div class="buttons-row">
              <a class="button" href="/catalog">Вернуться в каталог</a>
              <a class="button button-alt" href="/">На главную</a>
            </div>
          @endif

          <div class="prose" style="margin-top: 40px">
            @php
              $tips = [
                '<p>Сад - это не просто место красоты, это целый мир наблюдений.</p>© Джон Эвелин',
                '<p>Чтобы вырастить сад, требуется много воды. Но большая часть её должна быть в виде пота.</p>© Лу Эриксон',
                '<p>Все растения счастливы, если о них заботятся: это универсальная истина. </p>© Зигфрид Сассун',
                '<p>Сад - это вера в завтрашний день.</p>© Одри Хепбёрн',
                '<p>Цивилизация процветает, когда люди сажают деревья, под которыми они никогда не будут сидеть.</p>© Греческая пословица',
                '<p>Чтобы жить, нужно солнце, свобода и маленький цветок.</p>© Ганс Кристиан Андерсен',
                '<p>Сад - это философия, показанная глазу.</p>© Уильям Сенека',
                '<p>Единственное, что нужно человеку на всю жизнь, - это сад и библиотека.<br></p>© Цицерон',
                '<p>В каждом саду есть своя звезда, и у тебя всегда есть шанс стать садовником.</p>© Джерри Гарсия',
                '<p>Если вы хотите быть счастливыми всю жизнь, вырастите сад.</p>© Китайская пословица',
              ];
              $tip = $tips[rand(0, count($tips) - 1)];
            @endphp

            <blockquote class="gardening-tip">
              {!! $tip !!}
            </blockquote>
          </div>

          <a class="header__logo" href="/">
            <img
              class="header__logo-image"
              src="{{ Vite::front('images/logo.svg') }}"
              alt="АгрономСити"
            />
          </a>
        </div>
      </section>
    </main>
  </body>
</html>
