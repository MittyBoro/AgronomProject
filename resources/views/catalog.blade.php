<x-layouts.main body_name="catalog">
  <x-a.breadcrumbs :list="[['Каталог', null]]" />

  <section class="special-offers">
    <div class="special-offers__container container">
      <div class="catalog-categories">
        @foreach (range(1, 9) as $category)
          <x-categories.card :category="$category" />
        @endforeach
      </div>

      <x-swiper.catalog-banner />
    </div>
  </section>

  {{-- catalog --}}
  <section class="catalog catalog__section">
    <div class="catalog__container container">
      <div class="catalog__title title">
        <h1>Каталог товаров</h1>
        <a class="button catalog__button" href="#">Самые дорогие</a>
      </div>
      <div class="catalog__products products__list">
        <!-- Promotion Items -->
        @foreach (range(1, 8) as $product)
          <x-products.card />
        @endforeach

        <div class="catalog__pagination pagination">
          <div class="button">Показать больше</div>
        </div>
      </div>
    </div>
  </section>
</x-layouts.main>
