@props([
  'head',
  'body',
  'page',
  'item',
  'popup',
])
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8" />

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />

    {{-- format-ignore-start --}}
    <title>{{ $attributes['meta_title'] ?? config('app.name') }}</title>
    <meta name="description" content="{{ $attributes['meta_description'] ?? '' }}" />

    <meta property="og:title" content="{{ $attributes['meta_title'] ?? config('app.name') }}" />
    <meta property="og:description" content="{{ $attributes['meta_description'] ?? '' }}" />
    <meta property="og:type" content="{{ $attributes['meta_type'] ?? 'website' }}" />
    <meta property="og:locale" content="ru_RU" />
    @isset($attributes['meta_image'])
      <meta property="og:image" content="{{ $attributes['meta_image'] }}" />
    @endisset

    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#63b555">
    <link rel="shortcut icon" href="/favicon/favicon.ico">
    <meta name="apple-mobile-web-app-title" content="АгрономСити">
    <meta name="application-name" content="АгрономСити">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-config" content="/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    {{-- format-ignore-end --}}

    @vite('resources/assets/scss/app.scss')
    @vite('resources/assets/js/app.js')

    {!! $head ?? '' !!}
  </head>
  <body class="preload page-{{ $attributes['body_name'] ?? 'main' }}">
    @auth
      {{-- <x-admin-bar :page="$page ?? null" :item="$item ?? null" /> --}}
    @endauth

    {{-- header --}}
    <header class="header">
      <div class="header__container container">
        <a href="/" class="header__logo">
          <picture>
            <source
              srcset="{{ vite_asset('images/logo.svg') }}"
              media="(max-width: 360px)"
            />
            <img
              src="{{ vite_asset('images/logo-big.svg') }}"
              alt="АгрономСити"
              class="header__logo-image"
            />
          </picture>
        </a>
        <nav class="header__nav">
          <ul class="header__nav-list">
            <li class="header__nav-item">
              <a href="/about" class="header__nav-link link">О нас</a>
            </li>
            <li class="header__nav-item">
              <a href="/delivery" class="header__nav-link link">Доставка</a>
            </li>
            <li class="header__nav-item">
              <a href="/payment" class="header__nav-link link">Оплата</a>
            </li>
            <li class="header__nav-item">
              <a href="/support" class="header__nav-link link">Поддержка</a>
            </li>
            <li class="header__nav-item">
              <a href="/contacts" class="header__nav-link link">Контакты</a>
            </li>
          </ul>
        </nav>
        <div class="header__search">
          <input
            type="text"
            class="header__search-input field-input"
            placeholder="Что вы ищете?"
          />
          <x-icon src="icons/search.svg" class="header__search-icon link" />
        </div>
        <div class="header__icons">
          <a href="/account-favorites" class="header__icon link">
            <x-icon src="icons/heart.svg" />
          </a>
          <a href="/cart" class="header__icon link">
            <x-icon src="icons/cart.svg" />
          </a>
          <a href="/account-index" class="header__icon link">
            <x-icon src="icons/user.svg" />
          </a>
          <div class="header__icon header__icon-menu" data-popup=".popup__menu">
            <x-icon src="icons/menu.svg" />
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
          <img
            src="{{ vite_asset('images/logo.svg') }}"
            alt="АгрономСити"
            class="footer__logo-image"
          />
          <div class="footer__description">
            <p>Lorem ipsum dolor sit amet consectetur. Commodo aliquam</p>
            <p>{{ config('app.name') }} © {{ date('Y') }}</p>
          </div>
        </div>
        <x-main-links />
      </div>
    </footer>

    <div class="to_top">
      <x-icon src="icons/arrow.svg" class="to_top__icon" />
    </div>
    <x-bottom-bar />

    {!! $body ?? '' !!}

    <div class="popups">
      {{--  --}}
      {!! $popup ?? '' !!}

      {{--  --}}
      <x-popups.menu />
    </div>
  </body>
</html>
