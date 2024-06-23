<x-layouts.main body_name="checkout">
  <x-breadcrumbs :list="[['Корзина', '/cart'], ['Оформление заказа', null]]" />

  {{-- checkout --}}
  <section class="checkout checkout__section">
    <div class="checkout__container container">
      <div class="checkout__title title">Оформление заказа</div>

      <form class="checkout__form">
        <div class="checkout__form-group">
          <label for="first_name" class="checkout__form-label">
            Имя получателя *
          </label>
          <input
            type="text"
            id="first_name"
            class="checkout__form-input field-input"
            required
          />
        </div>

        <div class="checkout__form-group">
          <label for="last_name" class="checkout__form-label">
            Фамилия получателя *
          </label>
          <input
            type="text"
            id="last_name"
            class="checkout__form-input field-input"
            required
          />
        </div>

        <div class="checkout__form-group">
          <label for="address" class="checkout__form-label">
            Город, улица *
          </label>
          <input
            type="text"
            id="address"
            class="checkout__form-input field-input"
            required
          />
        </div>

        <div class="checkout__form-group">
          <label for="house" class="checkout__form-label">
            Дом, этаж, квартира *
          </label>
          <input
            type="text"
            id="house"
            class="checkout__form-input field-input"
            required
          />
        </div>

        <div class="checkout__form-group">
          <label for="postcode" class="checkout__form-label">
            Почтовый индекс *
          </label>
          <input
            type="text"
            id="postcode"
            class="checkout__form-input field-input"
            required
          />
        </div>

        <div class="checkout__form-group field-label">
          <input
            type="checkbox"
            id="save-data"
            class="checkout__form-checkbox field-checkbox"
          />
          <label for="save-data" class="checkout__form-checkbox-label">
            Сохранить данные для следующего заказа
          </label>
        </div>
      </form>

      <div class="checkout__summary">
        @foreach (range(1, 2) as $item)
          <div class="checkout__item">
            <span class="checkout__item-image">
              <img
                src="{{ vite_asset('images/product-demo.png') }}"
                alt="Название товара"
                class="object-cover"
              />
            </span>
            <span class="checkout__item-name">Название товара</span>
            <span class="checkout__item-right">
              <span class="checkout__item-price">300₽</span>
              <span class="checkout__item-count">Кол-во: 2</span>
            </span>
          </div>
        @endforeach

        <div class="checkout__loyalty">
          <div class="checkout__loyalty-button button button-alt">
            Начислить баллы (10₽)
          </div>
          <div class="checkout__loyalty-button button">
            Списать баллы (300₽)
          </div>

          <div class="checkout__loyalty-range">
            <div class="field-range--bubble bubble"></div>
            <input
              type="range"
              min="0"
              max="28"
              value="14"
              class="checkout__loyalty-range--input field-range"
            />
            <div class="checkout__loyalty-range-values">
              <span class="range-label">0 бонусов</span>
              <span class="range-label">28 бонусов</span>
            </div>
          </div>
        </div>

        <div class="checkout__promo">
          <input
            type="text"
            class="checkout__promo-input button button-input"
            placeholder="Промокод"
          />
          <button class="checkout__promo-button button">Применить</button>
        </div>

        <div class="checkout__total">
          <span class="checkout__total-label">Товары:</span>
          <span class="checkout__total-value">600₽</span>
        </div>
        <div class="checkout__total-separator"></div>
        <div class="checkout__total">
          <span class="checkout__total-label">Доставка:</span>
          <span class="checkout__total-value">0₽</span>
        </div>
        <div class="checkout__total-separator"></div>
        <div class="checkout__total">
          <span class="checkout__total-label">Скидка:</span>
          <span class="checkout__total-value">-150₽</span>
        </div>
        <div class="checkout__total-separator"></div>
        <div class="checkout__total">
          <span class="checkout__total-label">Баллы:</span>
          <span class="checkout__total-value">-150₽</span>
        </div>
        <div class="checkout__total-separator"></div>
        <div class="checkout__total">
          <span class="checkout__total-label"><b>К оплате:</b></span>
          <span class="checkout__total-value"><b>300₽</b></span>
        </div>

        <div class="checkout__payment-methods">
          <div class="checkout__payment-method field-label">
            <input
              type="radio"
              id="card"
              name="payment"
              class="checkout__payment-radio field-radio"
            />
            <label for="card" class="checkout__payment-label">
              Банковской картой
              <img
                src="{{ vite_asset('images/visa-mastercard-mir.png') }}"
                alt="Visa MasterCard Mir"
                class="checkout__payment-icon"
              />
            </label>
          </div>
          <div class="checkout__payment-method field-label">
            <input
              type="radio"
              id="cash"
              name="payment"
              class="checkout__payment-radio field-radio"
              checked
            />
            <label for="cash" class="checkout__payment-label">
              Наличными при доставке
            </label>
          </div>
        </div>

        <div class="checkout__submit">
          <button class="checkout__submit-button button">Оформить заказ</button>
          <div class="checkout__privacy field-label">
            <input
              type="checkbox"
              id="privacy"
              class="checkout__privacy-checkbox field-checkbox"
            />
            <label for="privacy" class="checkout__privacy-checkbox-label">
              Нажимая эту кнопку я соглашаюсь с
              <a href="/privacy" class="link underline">
                Политикой конфиденциальности
              </a>
            </label>
          </div>
        </div>
      </div>
    </div>
  </section>
</x-layouts.main>
