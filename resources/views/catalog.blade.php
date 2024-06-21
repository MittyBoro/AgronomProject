<x-layouts.main body_name="catalog">
  <x-breadcrumbs :list="[['Каталог', null]]" />

  <section class="special-offers">
    <div class="container special-offers__container">
      <aside class="catalog-sidebar">
        <ul class="catalog-sidebar__categories">
          <li><a href="#" class="link">Основная категория 1</a></li>
          <li><a href="#" class="link">Основная категория 2</a></li>
          <li><a href="#" class="link">Категория 3</a></li>
          <li><a href="#" class="link">Категория 4</a></li>
          <li><a href="#" class="link">Категория 5</a></li>
          <li><a href="#" class="link">Категория 6</a></li>
          <li><a href="#" class="link">Категория 7</a></li>
          <li><a href="#" class="link">Категория 8</a></li>
          <li><a href="#" class="link">Категория 9</a></li>
        </ul>
      </aside>

      <x-swiper.catalog-banner />
    </div>
  </section>

  {{-- catalog --}}
  <section class="catalog catalog__section">
    <div class="catalog__container container">
      <div class="catalog__title title">
        <h1>Каталог товаров</h1>
        <a href="#" class="button catalog__button">Самые дорогие</a>
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
