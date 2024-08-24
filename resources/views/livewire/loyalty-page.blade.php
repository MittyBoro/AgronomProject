<main class="loyalty-page">
  <x-main.breadcrumbs :list="$breadcrumbs" />
  {{-- loyalty --}}
  <section class="loyalty__section">
    <div class="loyalty__container container">
      <x-main.title titleTag="h1" pretitle="Бонусная программа">
        <span style="margin-right: auto">
          Добро пожаловать в бонусную программу
          <span class="primary">АгрономСити</span>
        </span>
      </x-main.title>

      <div class="loyalty__features">
        <div class="loyalty__feature">
          <div class="loyalty__feature-icon">
            <x-main.icon src="icons/bonus-user.svg" />
          </div>
          <div class="loyalty__feature-text">
            Пройдите авторизацию на нашем сайте
          </div>
        </div>
        <div class="loyalty__feature">
          <div class="loyalty__feature-icon">
            <x-main.icon src="icons/bonus-box.svg" />
          </div>
          <div class="loyalty__feature-text">
            Совершайте покупки для вашего сада
          </div>
        </div>
        <div class="loyalty__feature">
          <div class="loyalty__feature-icon">
            <x-main.icon src="icons/bonus-percent.svg" />
          </div>
          <div class="loyalty__feature-text">
            Получайте до 10% баллами за каждый заказ
          </div>
        </div>
        <div class="loyalty__feature">
          <div class="loyalty__feature-icon">
            <x-main.icon src="icons/bonus-thumb.svg" />
          </div>
          <div class="loyalty__feature-text">
            Оплачивайте баллами до 50% от стоимости заказа
          </div>
        </div>
      </div>
    </div>
  </section>

  {{--  --}}
  <x-profile.loyalty-system />
</main>
