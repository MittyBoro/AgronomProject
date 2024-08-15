{{-- footer --}}
<footer class="footer">
  <div class="footer__container container">
    <div class="footer__line"></div>
    <div class="footer__logo">
      <img
        class="footer__logo-image"
        src="{{ Vite::front('images/logo.svg') }}"
        alt="АгрономСити"
      />
      <div class="footer__description">
        <p>Lorem ipsum dolor sit amet consectetur. Commodo aliquam</p>
        <p>{{ config('app.name') }} © {{ date('Y') }}</p>
      </div>
    </div>
    <x-main.footer-nav />
  </div>
</footer>
