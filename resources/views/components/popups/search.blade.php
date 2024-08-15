<div class="popup__search popup">
  <div class="popup__search-container container">
    <div class="popup__content">
      <div class="header__container popup__search--header__container">
        <div class="header__search popup__search-search">
          <input
            class="header__search-input popup__search-input field-input"
            type="text"
            placeholder="Что вы ищете?"
            autofocus
          />
          <x-a.icon class="header__search-icon link" src="icons/search.svg" />
        </div>
        <div class="popup__search-close popup__close link">
          <x-a.icon src="icons/close.svg" />
        </div>
      </div>
      <div class="popup__search-categories">
        @foreach ($categories as $category)
          <x-categories.card :category="$category" />
        @endforeach
      </div>
    </div>
  </div>
</div>
