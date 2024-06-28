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

        <x-form.input
          class="contacts__form"
          label="Ваше имя *"
          id="name"
          required
        />
        <x-form.input
          class="contacts__form"
          label="Ваше E-mail *"
          id="email"
          type="email"
          required
        />
        <x-form.input
          class="contacts__form"
          label="Ваш телефон *"
          id="phone"
          type="tel"
        />
        <x-form.textarea
          class="grid-col-full contacts__form"
          label="Ваше сообщение"
          id="message"
          rows="6"
          required
        />

        <div class="contacts__form-submit-row">
          <button type="submit" class="contacts__form-submit button">
            Отправить
          </button>
        </div>
      </form>
    </div>
  </section>
</x-layouts.main>
