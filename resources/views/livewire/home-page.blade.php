<main class="home-page">

  {{-- Первый экран --}}
  <section class="home__section">
    <div class="home__container container">
      <div class="home__content">
        <img class="home__image object-cover"
          src="{{ Vite::front('images/home-background.png') }}" alt="" />
        <div class="home__text white-blur-block">
          <div class="home__title">
            <h1>{{ $page->fields['home_title'] ?? '' }}</h1>
          </div>
          <p class="home__description">
            {{ $page->fields['home_description'] ?? '' }}
          </p>
          <a class="button home__button" href="/catalog">Перейти в каталог</a>
        </div>
      </div>
    </div>
  </section>

  {{-- Популярные товары --}}
  <livewire:lists.product-list title="Самое популярное" :products="$popularProducts"
    pretitle="Лучшее за месяц" :button="['/catalog', 'В каталог']" />

  {{-- Категории, swiper --}}
  <livewire:lists.category-list title="Выберите категорию" :products="$popularProducts"
    pretitle="Категории" :button="['/catalog', 'В каталог']" swiper />

  {{-- Товары со скидками --}}
  <livewire:lists.product-list title="Актуальные акции" :products="$discountsProducts"
    pretitle="Скидки" :button="['/catalog', 'В каталог']" />

  {{-- About --}}
  <section class="about__section">
    <div class="about__container container">
      <div class="about__image">
        <img src="{{ Vite::front('images/logo.svg') }}"
          alt="{{ config('app.name') }}" />
      </div>
      <div class="about__text">
        <x-main.title title="Наша компания" pretitle="О нас" />
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

  {{-- Статьи --}}
  <livewire:lists.article-list title="Программы подкормок" :articles="$articles"
    pretitle="Полезное" :button="['/catalog', 'В каталог']" />

  {{-- Отзывы --}}
  <livewire:lists.review-list title="Отзывы покупателей" :reviews="$reviews"
    pretitle="Клиенты о нас" />
</main>
