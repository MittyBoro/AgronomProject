<x-layouts.main body_name="cart">
  <x-breadcrumbs :list="[['Корзина', null]]" />

  {{-- cart --}}
  <section class="cart cart__section">
    <div class="cart__container container">
      <table class="cart__table">
        <thead class="cart__table-head">
          <tr>
            <th>Товар</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Итого</th>
          </tr>
        </thead>
        <tbody class="cart__table-body">
          @foreach (range(1, 2) as $item)
            <tr class="cart__item">
              <td class="cart__item-info">
                <span class="cart__item-image">
                  <img
                    src="{{ vite_asset('images/product-demo.png') }}"
                    alt="Название товара"
                    class="object-cover"
                  />
                </span>
                <span class="cart__item-name">Название товара</span>
              </td>
              <td class="cart__item-price">300₽</td>
              <td class="cart__item-quantity">
                <div class="product__quantity">
                  <div
                    class="button button-alt product__button product__button--quantity product__button--minus cart__item-quantity--button"
                  >
                    <x-icon src="icons/minus.svg" />
                  </div>
                  <input
                    class="button button-input product__button product__button--quantity product__button--input cart__item-quantity--button"
                    value="2"
                    type="number"
                    min="1"
                    max="999"
                  />
                  <div
                    class="button button-alt product__button--quantity product__button--plus cart__item-quantity--button"
                  >
                    <x-icon src="icons/plus.svg" />
                  </div>
                </div>
              </td>
              <td class="cart__item-total">300₽</td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <div class="cart__actions">
        <a href="/catalog" class="button button-alt cart__back-button">
          Вернуться в каталог
        </a>

        <div class="cart__summary">
          <div>
            <span class="cart__summary-label">Сумма:</span>
            <span class="cart__summary-value">300₽</span>
          </div>
          <a href="/order" class="button cart__checkout-button">
            Перейти к оформлению
          </a>
        </div>
      </div>
    </div>
  </section>
</x-layouts.main>
