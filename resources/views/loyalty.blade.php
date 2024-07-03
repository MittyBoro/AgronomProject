<x-layouts.main body_name="loyalty">
  <x-a.breadcrumbs :list="[['Бонусная программа', null]]" />

  {{-- loyalty --}}
  <section class="loyalty loyalty__section">
    <div class="loyalty__container container">
      <div class="loyalty__subtitle subtitle">Бонусная программа</div>
      <div class="loyalty__title title">
        <span>
          Добро пожаловать в бонусную программу
          <span class="primary">АгрономСити</span>
        </span>
      </div>

      <div class="loyalty__features">
        <div class="loyalty__feature">
          <div class="loyalty__feature-icon">
            <x-a.icon src="icons/bonus-user.svg" />
          </div>
          <div class="loyalty__feature-text">
            Пройдите авторизацию на нашем сайте
          </div>
        </div>
        <div class="loyalty__feature">
          <div class="loyalty__feature-icon">
            <x-a.icon src="icons/bonus-box.svg" />
          </div>
          <div class="loyalty__feature-text">
            Совершайте покупки для вашего сада
          </div>
        </div>
        <div class="loyalty__feature">
          <div class="loyalty__feature-icon">
            <x-a.icon src="icons/bonus-percent.svg" />
          </div>
          <div class="loyalty__feature-text">
            Получайте до 10% баллами за каждый заказ
          </div>
        </div>
        <div class="loyalty__feature">
          <div class="loyalty__feature-icon">
            <x-a.icon src="icons/bonus-thumb.svg" />
          </div>
          <div class="loyalty__feature-text">
            Оплачивайте баллами до 50% от стоимости заказа
          </div>
        </div>
      </div>
    </div>
  </section>

  {{--  --}}
  <x-a.loyalty-system />
</x-layouts.main>
