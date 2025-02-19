<div class="popup__menu popup">
  <div class="popup__menu-container container">
    <div class="popup__menu-header">
      <div class="header__container">
        <div class="header__search popup__menu-search">
          <input
            class="header__search-input field-input"
            type="text"
            placeholder="Что вы ищете?"
            autofocus
          />
          <x-main.icon
            class="header__search-icon link"
            src="icons/search.svg"
          />
        </div>
        <div class="popup__menu-close popup__close link">
          <x-main.icon src="icons/close.svg" />
        </div>
      </div>
      <div class="popup-menu__title title">Каталог</div>
      <div class="popup-menu__categories categories__list">
        @foreach ($categories as $category)
          <x-category.card :category="$category" />
        @endforeach
      </div>

      <div class="popup__menu-footer">
        <x-main.footer-nav />

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
      </div>
    </div>
  </div>
</div>
