<x-layouts.main body_name="contacts">
  <x-breadcrumbs :list="[ ['Контакты', null]]" />
  {{--  --}}
  <section class="contacts__section">
    <div class="contacts__container container">
      <div class="contacts__info">
        <div class="contacts__item">
          <div class="contacts__title">
            <div class="contacts__icon">
              <x-icon src="icons/phone.svg" />
            </div>
            <span>Телефон для связи</span>
          </div>
          <div class="contacts__text">График приема звонков</div>
          <div class="contacts__text contacts__phone-number">
            Телефон: +7 999 999 99 99
          </div>
        </div>
        <div class="contacts__info-separator"></div>
        <div class="contacts__item">
          <div class="contacts__title">
            <div class="contacts__icon">
              <x-icon src="icons/envelope.svg" />
            </div>
            <span>Пишите нам</span>
          </div>
          <div class="contacts__text">Можете писать в любое время</div>
          <div class="contacts__text contacts__email-address">
            почта@gmail.com
          </div>
          <div class="contacts__text contacts__email-address">
            почта@gmail.com
          </div>
        </div>
      </div>
      <form class="contacts__form">
        <div class="contacts__form-title title"><span>Написать нам</span></div>
        <input
          type="text"
          class="contacts__form-input field-input"
          placeholder="Ваше имя *"
          required
        />
        <input
          type="email"
          class="contacts__form-input field-input"
          placeholder="Ваш Email *"
          required
        />
        <input
          type="tel"
          class="contacts__form-input field-input"
          placeholder="Ваш телефон *"
          required
        />
        <textarea
          class="contacts__form-textarea field-textarea"
          placeholder="Ваше сообщение"
          rows="6"
        ></textarea>
        <div class="contacts__form-submit-row">
          <button type="submit" class="contacts__form-submit button">
            Отправить
          </button>
        </div>
      </form>
    </div>
  </section>
</x-layouts.main>
