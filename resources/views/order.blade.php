<x-layouts.main body_name="order">
  <x-breadcrumbs :list="[['Корзина', '/cart'], ['Оформление заказа', null]]" />

  {{-- order --}}
  <section class="order order__section">
    <div class="order__container container">
      <div class="order__title title">Оформление заказа</div>

      <form class="order__form">
        <div class="order__form-group">
          <label for="name" class="order__form-label">Ваше имя *</label>
          <input
            type="text"
            id="name"
            class="order__form-input field-input"
            required
          />
        </div>

        <div class="order__form-group">
          <label for="surname" class="order__form-label">Ваша фамилия *</label>
          <input
            type="text"
            id="surname"
            class="order__form-input field-input"
            required
          />
        </div>

        <div class="order__form-group">
          <label for="address" class="order__form-label">Город, улица *</label>
          <input
            type="text"
            id="address"
            class="order__form-input field-input"
            required
          />
        </div>

        <div class="order__form-group">
          <label for="house" class="order__form-label">
            Дом, этаж, квартира *
          </label>
          <input
            type="text"
            id="house"
            class="order__form-input field-input"
            required
          />
        </div>

        <div class="order__form-group">
          <label for="postcode" class="order__form-label">
            Почтовый индекс *
          </label>
          <input
            type="text"
            id="postcode"
            class="order__form-input field-input"
            required
          />
        </div>

        <div class="order__form-group">
          <label for="phone" class="order__form-label">Телефон *</label>
          <input
            type="tel"
            id="phone"
            class="order__form-input field-input"
            required
          />
        </div>

        <div class="order__form-group">
          <label for="email" class="order__form-label">Email *</label>
          <input
            type="email"
            id="email"
            class="order__form-input field-input"
            required
          />
        </div>

        <div class="order__form-group field-label">
          <input
            type="checkbox"
            id="save-data"
            class="order__form-checkbox field-checkbox"
          />
          <label for="save-data" class="order__form-checkbox-label">
            Сохранить данные для следующего заказа
          </label>
        </div>
      </form>

      <div class="order__summary">
        @foreach (range(1, 2) as $item)
          <div class="order__item">
            <span class="order__item-image">
              <img
                src="{{ vite_asset('images/product-demo.png') }}"
                alt="Название товара"
                class="object-cover"
              />
            </span>
            <span class="order__item-name">Название товара</span>
            <span class="order__item-right">
              <span class="order__item-price">300₽</span>
              <span class="order__item-count">Кол-во: 2</span>
            </span>
          </div>
        @endforeach

        <div class="order__loyalty">
          <div class="order__loyalty-button button button-alt">
            Начислить баллы (10₽)
          </div>
          <div class="order__loyalty-button button">Списать баллы (300₽)</div>

          <div class="order__loyalty-range">
            <div class="field-range--bubble bubble"></div>
            <input
              type="range"
              min="0"
              max="28"
              value="14"
              class="order__loyalty-range--input field-range"
            />
            <div class="order__loyalty-range-values">
              <span class="range-label">0 бонусов</span>
              <span class="range-label">28 бонусов</span>
            </div>
          </div>
        </div>

        <div class="order__promo">
          <input
            type="text"
            class="order__promo-input button button-input"
            placeholder="Промокод"
          />
          <button class="order__promo-button button">Применить</button>
        </div>

        <div class="order__total">
          <span class="order__total-label">Товары:</span>
          <span class="order__total-value">600₽</span>
        </div>
        <div class="order__total-separator"></div>
        <div class="order__total">
          <span class="order__total-label">Доставка:</span>
          <span class="order__total-value">0₽</span>
        </div>
        <div class="order__total-separator"></div>
        <div class="order__total">
          <span class="order__total-label">Скидка:</span>
          <span class="order__total-value">-150₽</span>
        </div>
        <div class="order__total-separator"></div>
        <div class="order__total">
          <span class="order__total-label">Баллы:</span>
          <span class="order__total-value">-150₽</span>
        </div>
        <div class="order__total-separator"></div>
        <div class="order__total">
          <span class="order__total-label"><b>К оплате:</b></span>
          <span class="order__total-value"><b>300₽</b></span>
        </div>

        <div class="order__payment-methods">
          <div class="order__payment-method field-label">
            <input
              type="radio"
              id="card"
              name="payment"
              class="order__payment-radio field-radio"
            />
            <label for="card" class="order__payment-label">
              Банковской картой
              <img
                src="{{ vite_asset('images/visa-mastercard-mir.png') }}"
                alt="Visa MasterCard Mir"
                class="order__payment-icon"
              />
            </label>
          </div>
          <div class="order__payment-method field-label">
            <input
              type="radio"
              id="cash"
              name="payment"
              class="order__payment-radio field-radio"
              checked
            />
            <label for="cash" class="order__payment-label">
              Наличными при доставке
            </label>
          </div>
        </div>

        <div class="order__submit">
          <button class="order__submit-button button">Оформить заказ</button>
          <div class="order__privacy field-label">
            <input
              type="checkbox"
              id="privacy"
              class="order__privacy-checkbox field-checkbox"
            />
            <label for="privacy" class="order__privacy-checkbox-label">
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
