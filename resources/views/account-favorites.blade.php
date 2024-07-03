<x-layouts.account name="favorites">
  {{-- account-favorites --}}
  <section class="account-favorites">
    <div class="account-favorites__container container">
      <div class="account-favorites__title account__title">
        <div>Избранные товары (8)</div>
        <a class="button button-alt account-favorites__button" href="#">
          Добавить все в корзину
        </a>
      </div>
      <div class="account-favorites__products products__list">
        <!-- Promotion Items -->
        @foreach (range(1, 8) as $product)
          <x-products.card />
        @endforeach

        <div class="account-favorites__pagination pagination">
          <div class="button">Показать больше</div>
        </div>
      </div>
    </div>
  </section>
</x-layouts.account>
