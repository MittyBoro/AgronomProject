<x-layouts.main body_name="wishlist">
  <x-breadcrumbs :list="[['Каталог', '/catalog'], ['Избранное', null]]" />

  {{-- wishlist --}}
  <section class="wishlist wishlist__section">
    <div class="wishlist__container container">
      <div class="wishlist__title title">
        <h1>Избранное (8)</h1>
        <a href="#" class="button button-alt wishlist__button">
          Добавить все в корзину
        </a>
      </div>
      <div class="wishlist__products products__list">
        <!-- Promotion Items -->
        @foreach (range(1, 8) as $product)
          <x-products.card />
        @endforeach

        <div class="wishlist__pagination pagination">
          <div class="button">Показать больше</div>
        </div>
      </div>
    </div>
  </section>
</x-layouts.main>
