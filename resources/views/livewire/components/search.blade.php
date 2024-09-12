<div class="popup__content">
  <div class="header__container popup__search--header__container">
    <div class="header__search popup__search-search">
      <input
        class="header__search-input popup__search-input field-input"
        type="text"
        placeholder="Что вы ищете?"
        wire:model.live.debounce.500ms="search"
        autofocus
      />
      <x-main.icon class="header__search-icon link" src="icons/search.svg" />
    </div>
    <div class="popup__search-close popup__close link" wire:ignore>
      <x-main.icon src="icons/close.svg" />
    </div>
  </div>
  <div wire:loading.class="loading" style="min-height: calc(100vh - 230px)">
    @if (

      ! empty($search) &&
      ($productsResult->isNotEmpty() ||
        $articlesResult->isNotEmpty() ||
        $categoriesResult->isNotEmpty())    )
      {{--  --}}
      <div class="head-row__title popup__search-title">
        Результаты поиска по запросу «{{ $search }}»
      </div>

      <div class="popup__search-list">
        {{-- товары --}}
        @foreach ($productsResult as $item)
          <div class="popup__search-item popup__search-product">
            <div class="popup__search-item--image">
              <x-main.picture
                class="object-cover"
                :media="$item->media->first()"
              />
            </div>
            <div class="popup__search-item--title">
              <a href="{{ route('product', $item->slug) }}" class="link">
                {{ $item->title }}
              </a>
            </div>
            <div class="popup__search-item--price" style="margin-left: auto">
              {{ price_formatter($item->total_price) }} ₽
            </div>
            <div class="popup__search-item--button">
              <a
                href="{{ route('product', $item->slug) }}"
                class="button button-alt button-mini"
                wire:navigate
              >
                <x-main.icon src="icons/cart.svg" />
              </a>
            </div>
          </div>
        @endforeach

        <div class="popup__search-item"></div>

        {{-- статьи --}}
        @foreach ($articlesResult as $item)
          <div class="popup__search-item popup__search-article">
            <div class="popup__search-item--image">
              <x-main.picture
                class="object-cover"
                :media="$item->media->first()"
              />
            </div>
            <div class="popup__search-item--title">
              <a href="{{ route('article', $item->slug) }}" class="link">
                {{ $item->title }}
              </a>
            </div>
          </div>
        @endforeach

        <div class="popup__search-item"></div>

        {{-- категори --}}
        @foreach ($categoriesResult as $item)
          <div class="popup__search-item popup__search-category">
            <div class="popup__search-item--image">
              <x-main.picture
                class="object-cover"
                :media="$item->media->first()"
              />
            </div>
            <div class="popup__search-item--title">
              <a href="{{ route('category', $item->slug) }}" class="link">
                {{ $item->title }}
              </a>
            </div>
          </div>
        @endforeach
      </div>
    @elseif (empty($search))
      {{-- категори с пустым запросом --}}
      @if ($categoriesResult->isNotEmpty())
        <div class="popup__search-list">
          <div class="popup__search-categories categories__list">
            @foreach ($categoriesResult as $category)
              <x-category.card :category="$category" />
            @endforeach
          </div>
        </div>
      @endif
    @else
      {{-- nothing found --}}
      <div class="head-row__title popup__search-title">
        Ничего не найдено по запросу «{{ $search }}»
      </div>
    @endif
  </div>
</div>
