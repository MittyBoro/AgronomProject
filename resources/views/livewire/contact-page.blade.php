<main class="contacts-page">
  {{-- хлебушек --}}
  <x-main.breadcrumbs :list="$breadcrumbs" />

  <section class="contacts__section">
    <div class="contacts__container container">
      <div class="contacts__info">
        <div class="contacts__item">
          <div class="contacts__title">
            <div class="contacts__icon">
              <x-main.icon src="icons/phone.svg" />
            </div>
            <span>Телефон для связи</span>
          </div>
          @isset($contacts['schedule'])
            <div class="contacts__text">{{ $contacts['schedule'] }}</div>
          @endisset

          @foreach (range(1, 3) as $i)
            @isset($contacts['phone_' . $i])
              <div class="contacts__text contacts__phone-number">
                Телефон:
                <a href="tel:{{ $contacts['phone_' . $i] }}" class="link">
                  {{ phone_formatter($contacts['phone_' . $i]) }}
                </a>
              </div>
            @endisset
          @endforeach
        </div>
        {{--  --}}
        <div class="contacts__info-separator"></div>
        {{--  --}}
        <div class="contacts__item">
          <div class="contacts__title">
            <div class="contacts__icon">
              <x-main.icon src="icons/envelope.svg" />
            </div>
            <span>Пишите нам</span>
          </div>
          <div class="contacts__text">Можете писать в любое время</div>
          @foreach (range(1, 3) as $i)
            @isset($contacts['email_' . $i])
              <div class="contacts__text contacts__email-address">
                <a href="mailto:{{ $contacts['email_' . $i] }}" class="link">
                  {{ $contacts['email_' . $i] }}
                </a>
              </div>
            @endisset
          @endforeach
        </div>
      </div>
      <form wire:submit.prevent="submit" class="contacts__form">
        <div class="contacts__form-title head-row__title">
          <h1>Написать нам</h1>
        </div>
        <div class="contacts__form-messages">
          <x-form.validation-errors />
          <x-form.session-status />
        </div>

        <x-form.input
          class="contacts__form"
          id="name"
          label="Ваше имя"
          wire:model="form.name"
          required
        />
        <x-form.input
          class="contacts__form"
          id="email"
          type="email"
          label="Ваш email"
          wire:model="form.email"
          required
        />
        <x-form.input
          class="contacts__form"
          id="phone"
          type="tel"
          wire:model="form.phone"
          label="Ваш телефон"
        />
        <x-form.textarea
          class="grid-col-full contacts__form"
          id="message"
          label="Ваше сообщение"
          rows="6"
          wire:model="form.message"
          required
        />
        @if (! session()->has('status'))
          <div class="contacts__form-submit-row">
            <button class="contacts__form-submit button" type="submit">
              Отправить
            </button>
          </div>
        @endif
      </form>
    </div>
  </section>
</main>
