<x-layouts.main body_name="catalog" :page="$category ?: $page">


  <x-a.breadcrumbs :list="[
      ['Каталог', '/catalog'],
      ...[$category ? [$category->title, $category->slug] : null],
  ]" />

  @if (!$sort && !$category)
    <section class="special-offers">
      <div class="special-offers__container container">
        <div class="catalog-categories">
          @foreach ($component->categories as $category)
            <x-categories.card :category="$category" />
          @endforeach
        </div>

        <x-swiper.catalog-banner />
      </div>
    </section>
  @else
    <section class="catalog__categories categories categories__section">
      <div class="categories__container container">
        <div class="categories__list">
          <x-swiper.categories :component="$component" />
        </div>
        <div class="categories__title title">
          <div class="nav-arrows">
            <div class="nav-arrow nav-arrow__prev" href="#">
              <x-a.icon src="icons/arrow.svg" />
            </div>
            <div class="nav-arrow nav-arrow__next" href="#">
              <x-a.icon src="icons/arrow.svg" />
            </div>
          </div>
        </div>
      </div>
    </section>
  @endif

  {{-- catalog --}}
  <section class="catalog catalog__section" id="catalog"
    x-data="catalog">
    <div class="catalog__container container"
      x-class="{'catalog__container--loading': loading}">
      <div class="catalog__title title">
        <h1 data-title>{{ $category?->title ?: 'Каталог товаров' }}</h1>

        {{-- сортировка --}}
        <div class="dropdown">
          <div class="dropdown__button button catalog__button"
            x-text="activeSort.label">Новинки</div>
          <div class="dropdown__content">
            {{-- переменные вверху страницы --}}
            <template x-for="item in sortList">
              <span class=dropdown__item x-text="item.label"
                :class="{ 'dropdown__item--active': activeSort.label == item.label }"
                x-on:click="query.sort = item.key"></span>
            </template>
          </div>
        </div>
      </div>
      <div class="catalog__products products__list" id="catalog_list">
        <!-- Promotion Items -->
        <x-products.list :products="$products" />

      </div>
    </div>
  </section>

  <x-slot:body>
    <script>
      const $page = {
        catalog: true,
        title: @json($page['title']),
        categories: @json($component->categories),
      }
    </script>
  </x-slot>
</x-layouts.main>
