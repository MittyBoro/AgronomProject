<main class="checkout-page">
  <x-main.breadcrumbs :list="$breadcrumbs" />

  {{-- checkout --}}
  <section class="checkout checkout__section">
    <form wire:submit.prevent="submit" class="checkout__container container">
      <div class="checkout__title head-row__title">Оформление заказа</div>
      <div class="checkout__messages">
        <x-form.validation-errors />
        <x-form.session-status />
      </div>
      {{-- данные клиента --}}
      <div class="checkout__form">
        {{--  --}}
        <x-form.input
          class="checkout__form"
          id="full_name"
          label="Фамилия Имя Отчество"
          wire:model="form.full_name"
          autocomplete="name"
          required
        />
        {{--  --}}
        <x-form.input
          class="checkout__form"
          id="email"
          type="email"
          label="E-mail"
          wire:model="form.email"
          autocomplete="email"
          required
        />
        {{--  --}}
        <x-form.input
          class="checkout__form"
          id="phone"
          type="tel"
          label="Телефон"
          wire:model="form.phone"
          autocomplete="tel"
          required
        />

        {{--  --}}
        <x-form.input
          class="checkout__form"
          id="postal_code"
          type="number"
          label="Почтовый индекс"
          x-mask="999999"
          autocomplete="postal-code"
          wire:model="form.postal_code"
        />

        {{--  --}}
        <x-form.input
          class="checkout__form"
          id="city"
          label="Город, Деревня, Область, Район"
          wire:model="form.city"
          autocomplete="address-level1"
          required
        />

        {{--  --}}
        <x-form.textarea
          class="checkout__form"
          id="address"
          label="Улица, дом (этаж, квартира)"
          rows="3"
          wire:model="form.address"
          autocomplete="address-line1"
          required
        />

        {{--  --}}
        <x-form.textarea
          class="checkout__form"
          id="comment"
          label="Комментарий к заказу"
          rows="3"
          wire:model="form.comment"
        />

        {{--  --}}
        <x-form.checkbox
          class="checkout__form"
          id="save_info"
          label="Сохранить данные для следующего заказа"
          wire:model="form.save_info"
        />
      </div>

      <div class="checkout__summary">
        {{-- состав корзины --}}
        <div class="checkout__items">
          @foreach ($this->items as $item)
            <div class="checkout__item">
              <span class="checkout__item-image">
                <x-main.picture
                  class="object-cover"
                  :media="$item->product->media->first()"
                />
              </span>
              <span class="checkout__item-name">
                <a
                  class="link"
                  target="_blank"
                  href="{{ route('product', $item->product->slug) }}"
                >
                  {{ $item->product->title }}
                </a>
                <span class="checkout__item-variation">
                  {{ $item->variation?->full_title }}
                </span>
              </span>
              <span class="checkout__item-right">
                <span class="checkout__item-price">
                  {{ price_formatter($item->total_price) }} ₽
                </span>
                <span class="checkout__item-count">
                  Кол-во: {{ $item->quantity }}
                </span>
              </span>
            </div>
          @endforeach
        </div>

        {{-- бонусные баллы --}}
        <div class="checkout__loyalty">
          {{-- кнопки --}}
          <div
            class="checkout__loyalty-button button"
            :class="{'button-alt': !$wire.isEarnBonuses}"
            wire:click="isEarnBonuses = true; $wire.set('spentBonuses', 0)"
          >
            Начислить баллы
          </div>
          @if ($this->maxSpentBonuses)
            <div
              class="checkout__loyalty-button button"
              :class="{'button-alt': $wire.isEarnBonuses}"
              wire:click="isEarnBonuses = false"
            >
              или списать (до {{ price_formatter($this->maxSpentBonuses) }} ₽)
            </div>
          @endif

          {{-- списать --}}
          @if ($this->maxSpentBonuses)
            <div
              class="checkout__loyalty-range"
              x-cloak
              x-show="!$wire.isEarnBonuses"
            >
              <div class="field-range--bubble bubble"></div>
              <input
                class="checkout__loyalty-range--input field-range"
                type="range"
                min="0"
                max="{{ $this->maxSpentBonuses }}"
                wire:model.change="spentBonuses"
              />
              <div class="checkout__loyalty-range-values">
                <span class="range-label">0 бонусов</span>
                <span class="range-label">
                  {{ price_formatter($this->maxSpentBonuses) }} бонусов
                </span>
              </div>
              <p style="margin-top: 15px; text-align: center; opacity: 0.5">
                При списании бонусные баллы не зачисляются
              </p>
            </div>
          @endif

          {{-- начислить --}}
          <div
            class="checkout__loyalty-range prose"
            x-show="$wire.isEarnBonuses"
            wire:ignore
          >
            <p>
              После получения заказа на ваш счёт зачислится
              <b style="display: inline-block">
                {{ price_formatter($this->earnBonuses) }}
                <span
                  x-text="
                    $sklonenie($wire.earnBonuses, [
                      'бонусный балл',
                      'бонусных балла',
                      'бонусных баллов',
                    ])
                  "
                ></span>
              </b>
            </p>
            <p>
              <a
                href="{{ route('loyalty') }}"
                target="_blank"
                class="color-link"
              >
                Подробнее о бонусной программе
              </a>
            </p>
          </div>
        </div>

        {{-- промокод --}}
        <div class="checkout__promo">
          <input
            class="checkout__promo-input button button-input"
            :class="{'validated': $wire.couponAmount}"
            type="text"
            placeholder="Промокод"
            wire:model.trim="couponCode"
          />
          <div
            x-show="!$wire.couponAmount"
            wire:click="applyCoupon"
            class="checkout__promo-button button"
          >
            Применить
          </div>
          <div
            x-show="$wire.couponAmount"
            wire:click="set('couponCode', null);$wire.applyCoupon()"
            x-cloak
            class="checkout__promo-button button button-alt"
          >
            Отмена
          </div>
          @if ($couponError)
            <div class="checkout__promo-error">
              {{ $couponError }}
            </div>
          @endif
        </div>

        {{-- денежная инфа --}}
        {{-- subTotal --}}
        <div class="checkout__total">
          <span class="checkout__total-label">Товары:</span>
          <span class="checkout__total-value">
            {{ price_formatter($subTotal) }} ₽
          </span>
        </div>

        {{-- Доставка --}}
        @if (isset($deliveryPrice))
          <div class="checkout__total">
            <span class="checkout__total-label">Доставка:</span>
            <span class="checkout__total-value">0 ₽</span>
          </div>
        @endif

        {{-- Промокод --}}
        <div class="checkout__total" x-show="$wire.couponAmount">
          <span class="checkout__total-label">Промокод:</span>
          <span
            class="checkout__total-value"
            x-text="$price_formatter($wire.couponAmount * -1)"
          ></span>
        </div>

        {{-- спишет баллы --}}
        <div class="checkout__total" x-show="$wire.spentBonuses">
          <span class="checkout__total-label">Списать баллы:</span>
          <span
            class="checkout__total-value"
            x-text="$price_formatter($wire.spentBonuses * -1)"
          ></span>
        </div>

        {{-- зачислит баллы --}}
        <div class="checkout__total green" x-show="$wire.isEarnBonuses">
          <span class="checkout__total-label">Начислим за заказ:</span>
          <span class="checkout__total-value">
            <b>
              +{{ price_formatter($this->earnBonuses) }}
              <span
                x-text="$sklonenie($wire.earnBonuses, ['балл', 'балла', 'баллов'])"
              ></span>
            </b>
          </span>
        </div>

        {{-- total --}}
        <div class="checkout__total" style="border: 0">
          <span class="checkout__total-label"><b>К оплате:</b></span>
          <span class="checkout__total-value">
            <b>{{ price_formatter($this->total) }} ₽</b>
          </span>
        </div>

        {{-- способы оплаты --}}
        <div class="checkout__payment-methods">
          {{--  --}}
          <x-form.radio
            class="checkout__payment"
            id="card"
            name="payment_method"
            value="card"
            wire:model="form.payment_method"
            required
          >
            Банковской картой
            <img
              class="checkout__payment-icon"
              src="{{ Vite::front('images/visa-mastercard-mir.png') }}"
              alt="Visa MasterCard Mir"
            />
          </x-form.radio>
          {{--  --}}
          <x-form.radio
            class="checkout__payment"
            id="cash"
            name="payment_method"
            value="cash"
            wire:model="form.payment_method"
            required
          >
            Наличными при доставке
          </x-form.radio>
        </div>

        {{-- кнопочка --}}
        <div class="checkout__submit">
          <button class="checkout__submit-button button">Оформить заказ</button>

          {{--  --}}
          <x-form.checkbox class="checkout__privacy" id="privacy" required>
            Нажимая эту кнопку я соглашаюсь с
            <a class="link underline" href="/privacy">
              Политикой конфиденциальности
            </a>
          </x-form.checkbox>
        </div>
      </div>
    </form>
  </section>
</main>
