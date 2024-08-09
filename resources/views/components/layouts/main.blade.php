@props(['head', 'body', 'page', 'item', 'popup'])


<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />

  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />

  {{-- format-ignore-start --}}
  <title>{{ $attributes['meta_title'] ?? config('app.name') }}</title>
  <meta name="description"
    content="{{ $attributes['meta_description'] ?? '' }}" />

  <meta property="og:title"
    content="{{ $attributes['meta_title'] ?? config('app.name') }}" />
  <meta property="og:description"
    content="{{ $attributes['meta_description'] ?? '' }}" />
  <meta property="og:type"
    content="{{ $attributes['meta_type'] ?? 'website' }}" />
  <meta property="og:locale" content="ru_RU" />
  @isset($attributes['meta_image'])
    <meta property="og:image" content="{{ $attributes['meta_image'] }}" />
  @endisset

  <link href="/favicon/apple-touch-icon.png" rel="apple-touch-icon"
    sizes="180x180">
  <link type="image/png" href="/favicon/favicon-32x32.png" rel="icon"
    sizes="32x32">
  <link type="image/png" href="/favicon/favicon-16x16.png" rel="icon"
    sizes="16x16">
  <link href="/favicon/site.webmanifest" rel="manifest">
  <link href="/favicon/safari-pinned-tab.svg" rel="mask-icon" color="#63b555">
  <link href="/favicon/favicon.ico" rel="shortcut icon">
  <meta name="apple-mobile-web-app-title" content="АгрономСити">
  <meta name="application-name" content="АгрономСити">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-config" content="/favicon/browserconfig.xml">
  <meta name="theme-color" content="#ffffff">
  {{-- format-ignore-end --}}

  @vite(config('app.resources.front') . '/scss/app.scss')
  @vite(config('app.resources.front') . '/js/app.js')

  {!! $head ?? '' !!}
</head>

<body class="preload page-{{ $attributes['body_name'] ?? 'main' }}">
  @auth
    {{-- <x-admin-bar :page="$page ?? null" :item="$item ?? null" /> --}}
  @endauth

  {{-- header --}}
  <header class="header">
    <div class="header__container container">
      <a class="header__logo" href="/">
        <picture>
          <source srcset="{{ Vite::front('images/logo.svg') }}"
            media="(max-width: 360px)" />
          <img class="header__logo-image"
            src="{{ Vite::front('images/logo-big.svg') }}" alt="АгрономСити" />
        </picture>
      </a>
      <nav class="header__nav">
        <ul class="header__nav-list">
          <li class="header__nav-item">
            <a class="header__nav-link link" href="/catalog">Каталог</a>
          </li>
          <li class="header__nav-item">
            <a class="header__nav-link link" href="/about">О нас</a>
          </li>
          <li class="header__nav-item">
            <a class="header__nav-link link" href="/delivery">Доставка</a>
          </li>
          <li class="header__nav-item">
            <a class="header__nav-link link" href="/payment">Оплата</a>
          </li>
          <li class="header__nav-item">
            <a class="header__nav-link link" href="/contacts">Контакты</a>
          </li>
        </ul>
      </nav>
      <div class="header__search" data-popup=".popup__search">
        <input class="header__search-input field-input" type="text"
          placeholder="Что вы ищете?" readonly />
        <x-a.icon class="header__search-icon link" src="icons/search.svg" />
      </div>
      <div class="header__icons">
        <a class="header__icon link" href="/account-favorites">
          <x-a.icon src="icons/heart.svg" />
        </a>
        <a class="header__icon link" href="/cart">
          <x-a.icon src="icons/cart.svg" />
        </a>
        <a class="header__icon link" href="/account-index">
          <x-a.icon src="icons/user.svg" />
        </a>
        <div class="header__icon header__icon-menu" data-popup=".popup__menu">
          <x-a.icon src="icons/menu.svg" />
        </div>
      </div>
    </div>
  </header>

  {{-- main content --}}
  <main class="main">
    {{ $slot }}
  </main>

  {{-- footer --}}
  <footer class="footer">
    <div class="footer__container container">
      <div class="footer__line"></div>
      <div class="footer__logo">
        <img class="footer__logo-image"
          src="{{ Vite::front('images/logo.svg') }}" alt="АгрономСити" />
        <div class="footer__description">
          <p>Lorem ipsum dolor sit amet consectetur. Commodo aliquam</p>
          <p>{{ config('app.name') }} © {{ date('Y') }}</p>
        </div>
      </div>
      <x-a.footer-links />
    </div>
  </footer>


  <div class="to_top">
    <x-a.icon class="to_top__icon" src="icons/arrow.svg" />
  </div>
  <x-a.bottom-bar />

  {!! $body ?? '' !!}

  <div class="popups">
    {{--  --}}
    {!! $popup ?? '' !!}

    {{--  --}}
    <x-popups.menu :categories="$categories" />
    <x-popups.search :categories="$categories" />
  </div>
</body>

</html>
