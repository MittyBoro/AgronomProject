<x-layouts.main body_name="home" :page="$page">
  {{-- muzzle --}}
  <section class="muzzle muzzle__section">
    <div class="muzzle__container container">
      <div class="muzzle__content">
        <img class="muzzle__image object-cover"
          src="{{ Vite::front('images/muzzle-background.png') }}"
          alt="" />
        <div class="muzzle__text white-blur-block">
          <div class="muzzle__title">
            <h1>{{ $page->fields['home_title'] ?? '' }}</h1>
          </div>
          <p class="muzzle__description">
            {{ $page->fields['home_description'] ?? '' }}
          </p>
          <a class="button muzzle__button" href="/catalog">Перейти в каталог</a>
        </div>
      </div>
    </div>
  </section>

  {{-- popular --}}
  @if ($popularProducts->count())
    <section class="popular popular__section">
      <div class="popular__container container">
        <div class="popular__subtitle subtitle">Лучшее за месяц</div>
        <div class="popular__title title">
          <h2>Самое популярное</h2>
          <a class="button popular__button" href="/catalog">В каталог</a>
        </div>
        <div class="popular__products products__list">
          @foreach ($popularProducts as $item)
            <x-products.card :item="$item" />
          @endforeach
        </div>
      </div>
    </section>
  @endif

  {{-- categories --}}
  <section class="categories categories__section">
    <div class="categories__container container">
      <div class="categories__subtitle subtitle">Категории</div>
      <div class="categories__title title">
        <h2>Выберите категорию</h2>
        <div class="nav-arrows">
          <div class="nav-arrow nav-arrow__prev">
            <x-a.icon src="icons/arrow.svg" />
          </div>
          <div class="nav-arrow nav-arrow__next">
            <x-a.icon src="icons/arrow.svg" />
          </div>
        </div>
      </div>
      <div class="categories__list">
        <x-swiper.categories :component="$component" />
      </div>
    </div>
  </section>

  {{-- promotions --}}
  @if ($discountProducts->count())
    <section class="promotions promotions__section">
      <div class="promotions__container container">
        <div class="promotions__subtitle subtitle">Скидки</div>
        <div class="promotions__title title">
          <h2>Актуальные акции</h2>
          <a class="button promotions__button" href="/catalog">В каталог</a>
        </div>
        <div class="promotions__products products__list">
          <!-- Promotion Items -->
          @foreach ($discountProducts as $item)
            <x-products.card :item="$item" />
          @endforeach
        </div>
      </div>
    </section>
  @endif

  {{-- about --}}
  <section class="about about__section">
    <div class="about__container container">
      <div class="about__image">
        <img src="{{ Vite::front('images/logo.svg') }}"
          alt="{{ config('app.name') }}" />
      </div>
      <div class="about__text">
        <div class="about__subtitle subtitle">О нас</div>
        <div class="about__title title">
          <h2>Наша компания</h2>
        </div>
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
        <a class="button about__button" href="/about">Узнать больше</a>
      </div>
    </div>
  </section>

  {{-- articles --}}
  @if ($articles->count())
    <section class="articles articles__section">
      <div class="articles__container container">
        <div class="articles__subtitle subtitle">Полезное</div>
        <div class="articles__title title">
          <h2>Программы подкормок</h2>
          <a class="button articles__button" href="/articles">Посмотреть все</a>
        </div>
        <div class="articles__list">
          <!-- Article Items -->
          @foreach ($articles as $item)
            <x-articles.card :item="$item" />
          @endforeach
        </div>
      </div>
    </section>
  @endif

  {{-- reviews --}}
  @if ($reviews->count())
    <section class="reviews reviews__section">
      <div class="reviews__container container">
        <div class="reviews__subtitle subtitle">Клиенты о нас</div>
        <div class="reviews__title title">
          <h2>Отзывы покупателей</h2>
          {{-- <a class="button reviews__button" href="/catalog">Смотреть все</a> --}}
        </div>
        <div class="reviews__list">
          <!-- review Items -->
          @foreach ($reviews as $item)
            <x-reviews.card :item="$item" />
          @endforeach
        </div>
      </div>
    </section>
  @endif
</x-layouts.main>
