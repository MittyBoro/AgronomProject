<x-layouts.main body_name="contacts">
  <x-a.breadcrumbs :list="[['Контакты', null]]" />
  {{--  --}}
  <section class="contacts__section">
    <div class="contacts__container container">
      <div class="contacts__info">
        <div class="contacts__item">
          <div class="contacts__title">
            <div class="contacts__icon">
              <x-a.icon src="icons/phone.svg" />
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
              <x-a.icon src="icons/envelope.svg" />
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

        <x-form.input class="contacts__form" id="name" label="Ваше имя *"
          required />
        <x-form.input class="contacts__form" id="email" type="email"
          label="Ваше E-mail *" required />
        <x-form.input class="contacts__form" id="phone" type="tel"
          label="Ваш телефон *" />
        <x-form.textarea class="grid-col-full contacts__form" id="message"
          label="Ваше сообщение" rows="6" required />

        <div class="contacts__form-submit-row">
          <button class="contacts__form-submit button" type="submit">
            Отправить
          </button>
        </div>
      </form>
    </div>
  </section>
</x-layouts.main>
