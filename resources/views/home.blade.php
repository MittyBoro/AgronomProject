<x-layouts.main body_name="home">
  {{-- muzzle --}}
  <section class="muzzle muzzle__section">
    <div class="muzzle__container container">
      <div class="muzzle__content">
        <img
          src="{{ vite_asset('images/muzzle-background.png') }}"
          alt=""
          class="muzzle__image object-cover"
        />
        <div class="muzzle__text white-blur-block">
          <div class="muzzle__title">
            <h1>Тут будет какой-то оффер мол лучшая отрава для огорода</h1>
          </div>
          <p class="muzzle__description">
            Lorem ipsum dolor sit amet consectetur. Commodo aliquam quam netus
            augue. Pouere egestas mattis fames orci malesuada.
          </p>
          <a href="#" class="button muzzle__button">Перейти в каталог</a>
        </div>
      </div>
    </div>
  </section>

  {{-- about --}}
  <section class="about about__section">
    <div class="about__container container">
      <div class="about__image">
        <img
          src="{{ vite_asset('images/logo.svg') }}"
          alt="{{ config('app.name') }}"
        />
      </div>
      <div class="about__text">
        <div class="about__subtitle subtitle">О нас</div>
        <div class="about__title title"><h2>Наша компания</h2></div>
        <ul class="about__list check-list">
          <li class="about__item check-list__item">
            <b>Преимущество один:</b>
            Длинное описание преимущества
          </li>
          <li class="about__item check-list__item">
            <b>Преимущество два:</b>
            Длинное описание преимущества
          </li>
          <li class="about__item check-list__item">
            <b>Преимущество три:</b>
            Длинное описание преимущества
          </li>
          <li class="about__item check-list__item">
            <b>Преимущество четыре:</b>
            Длинное описание преимущества
          </li>
        </ul>
        <a href="#" class="button about__button">Узнать больше</a>
      </div>
    </div>
  </section>

  {{-- popular --}}
  <section class="popular popular__section">
    <div class="popular__container container">
      <div class="popular__subtitle subtitle">Лучшее за месяц</div>
      <div class="popular__title title">
        <h2>Самое популярное</h2>
        <a href="#" class="button popular__button">В каталог</a>
      </div>
      <div class="popular__products products__list">
        @foreach (range(1, 4) as $product)
          <x-products.card />
        @endforeach
      </div>
    </div>
  </section>

  {{-- categories --}}
  <section class="categories categories__section">
    <div class="categories__container container">
      <div class="categories__subtitle subtitle">Лучшее за месяц</div>
      <div class="categories__title title">
        <h2>Выберите категорию</h2>
        <div class="nav-arrows">
          <div href="#" class="nav-arrow nav-arrow__prev">
            <x-icon src="icons/arrow.svg" />
          </div>
          <div href="#" class="nav-arrow nav-arrow__next">
            <x-icon src="icons/arrow.svg" />
          </div>
        </div>
      </div>
      <div class="categories__list">
        <!-- Category Items -->
        @foreach (range(1, 6) as $product)
          <a href="#" class="category">
            <span class="category__icon">
              <img
                src="{{ vite_asset('images/logo.svg') }}"
                alt="Категория"
                class="default"
              />
            </span>
            <span class="category__name">Категория</span>
          </a>
        @endforeach
      </div>
    </div>
  </section>

  {{-- promotions --}}
  <section class="promotions promotions__section">
    <div class="promotions__container container">
      <div class="promotions__subtitle subtitle">Скидки</div>
      <div class="promotions__title title">
        <h2>Актуальные акции</h2>
        <a href="#" class="button promotions__button">В каталог</a>
      </div>
      <div class="promotions__products products__list">
        <!-- Promotion Items -->
        @foreach (range(1, 4) as $product)
          <x-products.card />
        @endforeach
      </div>
    </div>
  </section>

  {{-- articles --}}
  <section class="articles articles__section">
    <div class="articles__container container">
      <div class="articles__subtitle subtitle">Полезное</div>
      <div class="articles__title title">
        <h2>Программы подкормок</h2>
        <a href="#" class="button articles_button">В каталог</a>
      </div>
      <div class="articles__list">
        <!-- Article Items -->
        @foreach (range(1, 3) as $product)
          <x-articles.card />
        @endforeach
      </div>
    </div>
  </section>

  {{-- reviews --}}
  <section class="reviews reviews__section">
    <div class="reviews__container container">
      <div class="reviews__subtitle subtitle">Клиенты о нас</div>
      <div class="reviews__title title">
        <h2>Отзывы покупателей</h2>
        <a href="#" class="button reviews_button">Смотреть все</a>
      </div>
      <div class="reviews__list">
        <!-- review Items -->
        @foreach (range(1, 3) as $product)
          <x-reviews.card />
        @endforeach
      </div>
    </div>
  </section>
</x-layouts.main>
