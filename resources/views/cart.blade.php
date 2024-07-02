<x-layouts.main body_name="cart">
  <x-breadcrumbs :list="[['Корзина', null]]" />

  {{-- cart --}}
  <section class="cart cart__section">
    <div class="cart__container container">
      <div class="cart__title title">Ваша корзина</div>

      <div class="cart__table">
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
          @foreach (range(1, 3) as $item)
            <div class="cart__item cart__table-row">
              {{--  --}}
              <div class="cart__table-cell cart__item-image-cell">
                <div class="cart__item-image">
                  <img
                    src="{{ vite_asset('images/product-demo.png') }}"
                    alt="Название товара"
                    class="object-cover"
                  />
                </div>
              </div>
              {{--  --}}
              <div class="cart__table-cell cart__item-info-cell">
                <div class="cart__item-name">Название товара</div>
                <div class="cart__item-option">20ml</div>
              </div>
              {{--  --}}
              <div class="cart__table-cell cart__item-price">
                <span>300₽</span>
              </div>
              <div class="cart__table-cell">
                <div class="cart__item-quantity">
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
                </div>
              </div>
              {{--  --}}
              <div class="cart__table-cell cart__item-total">
                <span>300₽</span>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <div class="cart__actions">
        <a href="/catalog" class="button button-alt cart__back-button">
          Вернуться в каталог
        </a>

        <div class="cart__summary">
          <div>
            <span class="cart__summary-label">Сумма:</span>
            <span class="cart__summary-value">300₽</span>
          </div>
          <a href="/checkout" class="button cart__checkout-button">
            Перейти к оформлению
          </a>
        </div>
      </div>
    </div>
  </section>
</x-layouts.main>
