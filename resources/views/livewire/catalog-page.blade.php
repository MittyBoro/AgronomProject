<main class="catalog-page">
  {{-- хлебушек --}}
  <x-main.breadcrumbs :list="$breadcrumbs" />

  {{-- баннер --}}
  @if (! $categoryId)
    <livewire:lists.banner-list />
  @endif

  {{-- Категории, swiper --}}
  <livewire:lists.category-list :activeId="$categoryId" swiper />

  {{-- Товары --}}
  <x-product.list titleTag="h1" :$title :$products>
    {{-- сортировка --}}
    <div class="dropdown">
      <div class="dropdown__button button catalog__button">
        {{ $this->currentSort }}
      </div>
      <div class="dropdown__content">
        {{-- переменные вверху страницы --}}
        @foreach ($sortList as $key => $value)
          <span
            wire:click="setSort('{{ $key }}')"
            @class([
              'dropdown__item',
              'dropdown__item--active' => $this->sort == $key,
            ])
          >
            {!! $value !!}
          </span>
        @endforeach
      </div>
    </div>
  </x-product.list>
</main>
