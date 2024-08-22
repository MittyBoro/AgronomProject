@props(['title' => 'Авторизация', 'info' => null])
@php
  SEOMeta::setTitle($title);
  SEOMeta::addMeta('robots', 'noindex, nofollow');
@endphp

<x-layouts.app>
  <main class="auth-page">
    <section class="auth">
      <div class="container auth-container">
        <div class="auth__card">
          <div class="auth__card-title">{{ $title }}</div>

          <x-form.validation-errors />

          @isset($info)
            <div class="info__message">{!! $info !!}</div>
          @endisset

          @session('status')
            <div class="success__message">
              {{ $value }}
            </div>
          @endsession

          {{ $slot }}
        </div>
      </div>
    </section>
  </main>
</x-layouts.app>
