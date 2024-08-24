<div class="profile-order">
  <div class="profile-order__header">
    <div class="profile-order__number">Заказ #{{ $item }}</div>
    <div class="profile-order__date">12.12.2021 в 12:12</div>
    <div class="profile-order__status">
      <span
        class="profile-order__status-icon profile-order__status--{{ ['success', 'pending', 'danger'][rand(0, 2)] }}"
      ></span>
      <span>Ожидается оплата</span>
    </div>
    <x-a.icon
      class="profile-order__arrow active"
      src="icons/arrow-simple.svg"
    />
  </div>
  <div class="profile-order__body">
    <div class="profile-order__info">
      <div class="profile-order__info-header">Информация о заказе</div>
      <div class="profile-order__info-line profile__info-line">
        <div class="profile-order__info-title profile__info-title">
          Способ доставки
        </div>
        <div class="profile-order__info-text profile__info-text">Самовывоз</div>
      </div>
      <div class="profile-order__info-line profile__info-line">
        <div class="profile-order__info-title profile__info-title">
          Способ оплаты
        </div>
        <div class="profile-order__info-text profile__info-text">Наличные</div>
      </div>
      <div class="profile-order__info-line profile__info-line">
        <div class="profile-order__info-title profile__info-title">
          Стоимость доставки
        </div>
        <div class="profile-order__info-text profile__info-text">Бесплатно</div>
      </div>
      <div class="profile-order__info-line profile__info-line">
        <div class="profile-order__info-title profile__info-title">Скидка</div>
        <div class="profile-order__info-text profile__info-text">-500 руб.</div>
      </div>
      <div class="profile-order__info-line profile__info-line">
        <div class="profile-order__info-title profile__info-title">
          Начально бонусов
        </div>
        <div class="profile-order__info-text profile__info-text primary">
          <b>15</b>
        </div>
      </div>
      <div class="profile-order__info-line profile__info-line">
        <div class="profile-order__info-title profile__info-title">
          Сумма заказа
        </div>
        <div class="profile-order__info-text profile__info-text">
          <b>2 000 руб.</b>
        </div>
      </div>
    </div>
    <div class="profile-order__info">
      <div class="profile-order__info-header">Контактное лицо</div>
      <div class="profile-order__info-line profile__info-line">
        <div class="profile-order__info-title profile__info-title">
          Контактное лицо
        </div>
        <div class="profile-order__info-text profile__info-text">
          Иванов Иван Иванович
        </div>
      </div>
      <div class="profile-order__info-line profile__info-line">
        <div class="profile-order__info-title profile__info-title">Телефон</div>
        <div class="profile-order__info-text profile__info-text">
          +7 (999) 999-99-99
        </div>
      </div>
      <div class="profile-order__info-line profile__info-line">
        <div class="profile-order__info-title profile__info-title">E-mail:</div>
        <div class="profile-order__info-text profile__info-text">
          JkFkA@example.com
        </div>
      </div>
      <div class="profile-order__info-line profile__info-line">
        <div class="profile-order__info-title profile__info-title">
          Адрес доставки
        </div>
        <div class="profile-order__info-text profile__info-text">
          Москва, ул. Ленина, д. 1
        </div>
      </div>
    </div>
    <div class="profile-order__products">
      @foreach (range(1, rand(2, 5)) as $product)
        <div class="profile-order__product">
          <div class="profile-order__product-image cart__item-image">
            <img
              class="object-cover"
              src="{{ Vite::front('images/product-demo.png') }}"
              alt="{{ config('app.name') }}"
            />
          </div>
          <div class="profile-order__product-name">
            <a class="link" href="#" target="_blank">Грудка куриная</a>
            <div class="profile-order__product-option gray">5кг</div>
          </div>
          <div class="profile-order__product-price">
            <span>2 000 руб.</span>
            <span>× 2</span>
          </div>
          <div class="profile-order__product-total">
            <b>4 000 руб.</b>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
