<main class="product-page">
  {{-- хлебушек --}}
  <x-main.breadcrumbs :list="$breadcrumbs" />

  {{-- корзинка --}}
  <section class="cart__section">
    <div class="cart__container container">
      @if ($items->isNotEmpty())
        <div class="cart__table" wire:loading.class="loading">
          <div class="cart__table-head">
            <div class="cart__table-row">
              <div class="cart__table-cell"></div>
              <div class="cart__table-cell">Товар</div>
              <div class="cart__table-cell">Цена</div>
              <div class="cart__table-cell">Количество</div>
              <div class="cart__table-cell">Итого</div>
            </div>
          </div>
          <div class="cart__table-body">
            @foreach ($items as $item)
              <livewire:cart.item :key="$item->id" :$item />
            @endforeach
          </div>
        </div>

        <div class="cart__actions">
          <a class="button button-alt cart__back-button" href="/catalog">
            Вернуться в каталог
          </a>

          <div class="cart__summary">
            <div>
              <span class="cart__summary-label">Сумма:</span>
              <span class="cart__summary-value">
                {{ price_formatter($this->totalPrice) }}₽
              </span>
            </div>
            <a class="button cart__checkout-button" href="/checkout">
              Перейти к оформлению
            </a>
          </div>
        </div>
      @else
        <div class="cart__empty">
          <div class="cart__empty-image">
            <x-main.icon src="icons/cart.svg" />
          </div>
          <div class="cart__empty-text">Ваша корзина пуста :(</div>
          <a href="/catalog" class="button" wire:navigate>К покупкам</a>
        </div>
      @endif
    </div>
  </section>
</main>
