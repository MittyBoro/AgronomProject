<x-layouts.main body_name="checkout">
  <x-breadcrumbs :list="[['Корзина', '/cart'], ['Оформление заказа', null]]" />

  {{-- checkout --}}
  <section class="checkout checkout__section">
    <div class="checkout__container container">
      <div class="checkout__title title">Оформление заказа</div>

      <form class="checkout__form">
        {{--  --}}
        <x-form.input
          class="checkout__form"
          label="Фамилия Имя Отчество *"
          id="name"
          required
        />
        {{--  --}}
        <x-form.input
          class="checkout__form"
          label="E-mail *"
          type="email"
          id="name"
          required
        />
        {{--  --}}
        <x-form.input
          class="checkout__form"
          label="Телефон *"
          type="tel"
          id="phone"
          required
        />

        {{--  --}}
        <x-form.input
          class="checkout__form"
          label="Почтовый индекс"
          type="number"
          id="postcode"
          required
        />

        {{--  --}}
        <x-form.input
          class="checkout__form"
          label="Город, Деревня, Область, Район *"
          id="area"
          required
        />

        {{--  --}}
        <x-form.textarea
          class="checkout__form"
          label="Улица, дом (этаж, квартира) *"
          id="address"
          rows="3"
          required
        />

        {{--  --}}
        <x-form.checkbox
          class="checkout__form"
          label="Сохранить данные для следующего заказа"
          id="save-data"
          required
        />
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
          {{--  --}}
          <x-form.radio
            class="checkout__payment"
            id="card"
            name="payment"
            required
          >
            Банковской картой
            <img
              src="{{ vite_asset('images/visa-mastercard-mir.png') }}"
              alt="Visa MasterCard Mir"
              class="checkout__payment-icon"
            />
          </x-form.radio>
          {{--  --}}
          <x-form.radio
            class="checkout__payment"
            id="cash"
            name="payment"
            1
            required
          >
            Наличными при доставке
          </x-form.radio>
        </div>

        <div class="checkout__submit">
          <button class="checkout__submit-button button">Оформить заказ</button>

          {{--  --}}
          <x-form.checkbox class="checkout__privacy" id="privacy" required>
            Нажимая эту кнопку я соглашаюсь с
            <a href="/privacy" class="link underline">
              Политикой конфиденциальности
            </a>
          </x-form.checkbox>
        </div>
      </div>
    </div>
  </section>
</x-layouts.main>
