<x-layouts.main body_name="loyalty">
  <x-breadcrumbs :list="[['Бонусная программа', null]]" />

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
            <x-icon src="icons/bonus-user.svg" />
          </div>
          <div class="loyalty__feature-text">
            Пройдите авторизацию на нашем сайте
          </div>
        </div>
        <div class="loyalty__feature">
          <div class="loyalty__feature-icon">
            <x-icon src="icons/bonus-box.svg" />
          </div>
          <div class="loyalty__feature-text">
            Совершайте покупки для вашего сада
          </div>
        </div>
        <div class="loyalty__feature">
          <div class="loyalty__feature-icon">
            <x-icon src="icons/bonus-percent.svg" />
          </div>
          <div class="loyalty__feature-text">
            Получайте до 10% баллами за каждый заказ
          </div>
        </div>
        <div class="loyalty__feature">
          <div class="loyalty__feature-icon">
            <x-icon src="icons/bonus-thumb.svg" />
          </div>
          <div class="loyalty__feature-text">
            Оплачивайте баллами до 50% от стоимости заказа
          </div>
        </div>
      </div>

      <div class="loyalty__system">
        <h2 class="loyalty__system-title title">
          Гибкая накопительная система 1 балл = 1 рубль
        </h2>
        <div class="loyalty__levels">
          <div class="loyalty__level">
            <div class="loyalty__level-title">1 уровень</div>
            <div class="loyalty__level-percent">3%</div>
            <div class="loyalty__level-description">
              Выдается после авторизации
            </div>
          </div>
          <div class="loyalty__level">
            <div class="loyalty__level-title">2 уровень</div>
            <div class="loyalty__level-percent">4%</div>
            <div class="loyalty__level-description">
              Выдается при сумме заказов от 15 000₽
            </div>
          </div>
          <div class="loyalty__level">
            <div class="loyalty__level-title">3 уровень</div>
            <div class="loyalty__level-percent">5%</div>
            <div class="loyalty__level-description">
              Выдается при сумме заказов от 15 000₽
            </div>
          </div>
          <div class="loyalty__level">
            <div class="loyalty__level-title">4 уровень</div>
            <div class="loyalty__level-percent">6%</div>
            <div class="loyalty__level-description">
              Выдается при сумме заказов от 15 000₽
            </div>
          </div>
          <div class="loyalty__level">
            <div class="loyalty__level-title">5 уровень</div>
            <div class="loyalty__level-percent">7%</div>
            <div class="loyalty__level-description">
              Выдается при сумме заказов от 15 000₽
            </div>
          </div>
          <div class="loyalty__level">
            <div class="loyalty__level-title">6 уровень</div>
            <div class="loyalty__level-percent">8%</div>
            <div class="loyalty__level-description">
              Выдается при сумме заказов от 15 000₽
            </div>
          </div>
          <div class="loyalty__level">
            <div class="loyalty__level-title">7 уровень</div>
            <div class="loyalty__level-percent">9%</div>
            <div class="loyalty__level-description">
              Выдается при сумме заказов от 15 000₽
            </div>
          </div>
          <div class="loyalty__level">
            <div class="loyalty__level-title">8 уровень</div>
            <div class="loyalty__level-percent">10%</div>
            <div class="loyalty__level-description">
              Выдается при сумме заказов от 15 000₽
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</x-layouts.main>
