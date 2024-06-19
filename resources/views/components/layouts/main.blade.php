@props([
  'head',
  'body',
  'page',
  'item',
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

    <main class="wrapper">
      <header class="header-box">
        <nav class="container">
          <a href="/" class="logo">
            <img src="{{ asset('images/logo.svg') }}" alt="" />
          </a>
        </nav>
      </header>

      {{ $slot }}

      <footer class="footer-box">
        <div class="container"></div>
      </footer>
    </main>

    {!! $body ?? '' !!}
  </body>
</html>
