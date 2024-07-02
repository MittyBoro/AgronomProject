<div class="popup__menu popup">
  <div class="popup__menu-container container">
    <div class="popup__menu-header">
      <div class="header__container">
        <div class="header__search popup__menu-search">
          <input
            type="text"
            class="header__search-input field-input"
            placeholder="Что вы ищете?"
          />
          <x-icon src="icons/search.svg" class="header__search-icon link" />
        </div>
        <div class="popup__menu-close popup__close link">
          <x-icon src="icons/close.svg" />
        </div>
      </div>
      <div class="popup-menu__title title">Каталог</div>
      <div class="popup-menu__categories catalog-categories">
        @foreach (range(1, 9) as $category)
          <x-categories.card :category="$category" />
        @endforeach
      </div>

      <div class="popup__menu-footer">
        <x-main-links class_name="footer__links" />

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
      </div>
    </div>
  </div>
</div>
