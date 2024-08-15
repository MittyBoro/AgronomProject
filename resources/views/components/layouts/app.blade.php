<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    {{-- https://github.com/artesaos/seotools?tab=readme-ov-file#in-your-view --}}
    {!! SEO::generate() !!}

    {{-- Favicons --}}
    <link
      href="/favicon/apple-touch-icon.png"
      rel="apple-touch-icon"
      sizes="180x180"
    />
    <link
      type="image/png"
      href="/favicon/favicon-32x32.png"
      rel="icon"
      sizes="32x32"
    />
    <link
      type="image/png"
      href="/favicon/favicon-16x16.png"
      rel="icon"
      sizes="16x16"
    />
    <link href="/favicon/site.webmanifest" rel="manifest" />
    <link
      href="/favicon/safari-pinned-tab.svg"
      rel="mask-icon"
      color="#63b555"
    />
    <link href="/favicon/favicon.ico" rel="shortcut icon" />
    <meta name="apple-mobile-web-app-title" content="АгрономСити" />
    <meta name="application-name" content="АгрономСити" />
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="msapplication-config" content="/favicon/browserconfig.xml" />
    <meta name="theme-color" content="#ffffff" />

    @vite(config('app.resources.front') . '/scss/app.scss')
  </head>

  <body>
    <x-main.header />

    {{ $slot }}

    <x-main.footer />
    <x-main.mobile-nav />

    {{-- to top arrow --}}
    <div class="to-top">
      <x-main.icon class="to-top__icon" src="icons/arrow.svg" />
    </div>

    <div class="popups">
      {{--  --}}
      {!! $popup ?? '' !!}

      {{--  --}}
      {{--
        <x-popups.menu :categories="$categories" />
        <x-popups.search :categories="$categories" />
      --}}
    </div>

    @vite(config('app.resources.front') . '/js/app.js')
  </body>
</html>
