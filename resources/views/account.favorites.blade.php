<x-layouts.main body_name="favorites">
  <x-breadcrumbs
    :list="[['Личный кабинет', '/account'], ['Избранное', null]]"
  />

  {{-- favorites --}}
  <section class="favorites favorites__section">
    <div class="favorites__container container">
      <div class="favorites__title title">
        <h1>Избранное (8)</h1>
        <a href="#" class="button button-alt favorites__button">
          Добавить все в корзину
        </a>
      </div>
      <div class="favorites__products products__list">
        <!-- Promotion Items -->
        @foreach (range(1, 8) as $product)
          <x-products.card />
        @endforeach

        <div class="favorites__pagination pagination">
          <div class="button">Показать больше</div>
        </div>
      </div>
    </div>
  </section>
</x-layouts.main>
