@props([
  'head',
  'body',
  'page',
  'item',
])
<!DOCTYPE html>
<html lang="{{ locale() }}">
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
    <meta property="og:locale" content="{{ loc_REG() }}" />
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
    <meta name="msapplication-TileColor" content="#63b555">
    <meta name="msapplication-config" content="/favicon/browserconfig.xml">
    <meta name="theme-color" content="#63b555">
    {{-- format-ignore-end --}}

    @vite('resources/front/styles/style.sass')
    @vite('resources/front/js/app.js')

    {!! $head ?? '' !!}
  </head>
  <body class="preload page-{{ $attributes['body_name'] ?? 'main' }}">
    @auth
      <x-admin-bar :page="$page ?? null" :item="$item ?? null" />
    @endauth

    <main class="wrapper">
      <header class="header-box">
        <nav class="container">
          <div class="hamb-wrap">
            <div class="hamburger"></div>
          </div>
          <div class="col-menu left-menu">
            <div class="m-item">
              <a href="{{ route('front.pages', 'catalog') }}">Каталог</a>
            </div>
            <div class="m-item">
              <span class="a">
                <span>Категории</span>
                <img
                  src="{{ vite_asset('images/icons/arrow-down.svg') }}"
                  alt=""
                  class="icon to-svg"
                />
              </span>
              <div class="m-item-list">
                @foreach ($categories as $cat)
                  <a href="{{ route('front.categories', $cat['slug']) }}">
                    {{ $cat['title'] }}
                  </a>
                @endforeach
              </div>
            </div>
            <div class="m-item">
              <a href="{{ route('front.pages', 'delivery') }}">Доставка</a>
            </div>
          </div>
          <a href="{{ route('front.home') }}" class="logo">
            <x-svg src="/images/icons/logo.svg" />
          </a>
          <div class="col-menu right-menu">
            <div class="m-item">
              <a href="{{ route('front.pages', 'faq') }}">FAQ</a>
            </div>
            <div class="m-item">
              <a href="{{ route('front.pages', 'cart') }}">
                <!-- prettier-ignore -->
                Корзина
                <span class="cart-count">
                  {{ $cartCount ?? 0 }}
                </span>
              </a>
            </div>
          </div>
          <div class="cart-wrap">
            <div class="cart-icon a">
              <span class="int cart-count">
                {{ $cartCount ?? 0 }}
              </span>
              {{-- <x-svg src="/images/icons/shopping-bag.svg" /> --}}
            </div>
          </div>
        </nav>
      </header>

      <div class="menu-box">
        <div class="container">
          <div class="grid-row grid-2">
            {{-- @include('components.footer_category') --}}

            <div class="top-col">
              <div class="f-title mini-title primary">Клиентам</div>
              <ul>
                <li>
                  <a href="{{ route('front.pages', 'delivery') }}">Доставка</a>
                </li>
                <li>
                  <a href="{{ route('front.pages', 'faq') }}">FAQ</a>
                </li>
                <li>
                  <a href="{{ route('front.pages', 'contacts') }}">Контакты</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="bottom-row">
            <div class="gray">
              <a href="{{ $instagramUrl }}" target="_blank" class="insta">
                {{-- <x-svg src="/images/icons/instagram.svg" /> --}}
                <span>Наш Instagram</span>
              </a>
            </div>
          </div>
        </div>
      </div>

      {{ $slot }}

      <div class="footer-box">
        <div class="container">
          <div class="top-row grid-12">
            {{-- @include('components.footer_category') --}}

            <div class="top-col">
              <div class="f-title mini-title primary">Клиентам</div>
              <ul>
                <li>
                  <a href="{{ route('front.pages', 'delivery') }}">Доставка</a>
                </li>
                <li>
                  <a href="{{ route('front.pages', 'faq') }}">FAQ</a>
                </li>
                <li>
                  <a href="{{ route('front.pages', 'contacts') }}">Контакты</a>
                </li>
              </ul>
            </div>
          </div>

          <div class="bottom-row">
            <div class="politic-col">
              <a
                href="{{ route('front.pages', 'privacy') }}"
                class="politic-link"
              >
                Политика конфиденциальности
              </a>
            </div>
            <div class="insta-col">
              <a href="{{ $instagramUrl }}" target="_blank" class="insta">
                {{-- <x-svg src="/images/icons/instagram.svg" /> --}}
                <span>Наш Instagram</span>
              </a>
            </div>
            <p>АгрономСити © {{ date('Y') }}</p>
          </div>
        </div>
      </div>
    </main>

    {!! $body ?? '' !!}
  </body>
</html>
