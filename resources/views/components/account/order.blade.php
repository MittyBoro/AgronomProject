<div class="account-order">
  <div class="account-order__header">
    <div class="account-order__number">Заказ #{{ $item }}</div>
    <div class="account-order__date">12.12.2021 в 12:12</div>
    <div class="account-order__status">
      <span
        class="account-order__status-icon account-order__status--{{ ['success', 'pending', 'danger'][rand(0, 2)] }}"
      ></span>
      <span>Ожидается оплата</span>
    </div>
    <x-icon src="icons/arrow-simple.svg" class="account-order__arrow active" />
  </div>
  <div class="account-order__body">
    <div class="account-order__info">
      <div class="account-order__info-header">Информация о заказе</div>
      <div class="account-order__info-line account__info-line">
        <div class="account-order__info-title account__info-title">
          Способ доставки
        </div>
        <div class="account-order__info-text account__info-text">Самовывоз</div>
      </div>
      <div class="account-order__info-line account__info-line">
        <div class="account-order__info-title account__info-title">
          Способ оплаты
        </div>
        <div class="account-order__info-text account__info-text">Наличные</div>
      </div>
      <div class="account-order__info-line account__info-line">
        <div class="account-order__info-title account__info-title">
          Стоимость доставки
        </div>
        <div class="account-order__info-text account__info-text">Бесплатно</div>
      </div>
      <div class="account-order__info-line account__info-line">
        <div class="account-order__info-title account__info-title">Скидка</div>
        <div class="account-order__info-text account__info-text">-500 руб.</div>
      </div>
      <div class="account-order__info-line account__info-line">
        <div class="account-order__info-title account__info-title">
          Начально бонусов
        </div>
        <div class="account-order__info-text account__info-text primary">
          <b>15</b>
        </div>
      </div>
      <div class="account-order__info-line account__info-line">
        <div class="account-order__info-title account__info-title">
          Сумма заказа
        </div>
        <div class="account-order__info-text account__info-text">
          <b>2 000 руб.</b>
        </div>
      </div>
    </div>
    <div class="account-order__info">
      <div class="account-order__info-header">Контактное лицо</div>
      <div class="account-order__info-line account__info-line">
        <div class="account-order__info-title account__info-title">
          Контактное лицо
        </div>
        <div class="account-order__info-text account__info-text">
          Иванов Иван Иванович
        </div>
      </div>
      <div class="account-order__info-line account__info-line">
        <div class="account-order__info-title account__info-title">Телефон</div>
        <div class="account-order__info-text account__info-text">
          +7 (999) 999-99-99
        </div>
      </div>
      <div class="account-order__info-line account__info-line">
        <div class="account-order__info-title account__info-title">E-mail:</div>
        <div class="account-order__info-text account__info-text">
          JkFkA@example.com
        </div>
      </div>
      <div class="account-order__info-line account__info-line">
        <div class="account-order__info-title account__info-title">
          Адрес доставки
        </div>
        <div class="account-order__info-text account__info-text">
          Москва, ул. Ленина, д. 1
        </div>
      </div>
    </div>
    <div class="account-order__products">
      @foreach (range(1, rand(2, 5)) as $product)
        <div class="account-order__product">
          <div class="account-order__product-image cart__item-image">
            <img
              src="{{ vite_asset('images/product-demo.png') }}"
              alt="{{ config('app.name') }}"
              class="object-cover"
            />
          </div>
          <div class="account-order__product-name">
            <a href="#" target="_blank" class="link">Грудка куриная</a>
            <div class="account-order__product-option gray">5кг</div>
          </div>
          <div class="account-order__product-price">
            <span>2 000 руб.</span>
            <span>× 2</span>
          </div>
          <div class="account-order__product-total">
            <b>4 000 руб.</b>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
