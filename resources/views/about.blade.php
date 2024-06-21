<x-layouts.main body_name="about">
  <x-breadcrumbs :list="[['О нас', null]]" />
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
        <div class="about__prose prose">
          <p>
            Lorem ipsum dolor sit amet consectetur. Lectus diam sit nisl mattis
            aenean consectetur placerat rhoncus. Sollicitudin amet velit tellus
            sed adipiscing dictum aliquet. Non in amet turpis fermentum varius.
            Semper molestie pharetra commodo
          </p>
          <p>
            Consectetur. Lectus diam sit nisl mattis aenean consectetur placerat
            rhoncus. Sollicitudin amet velit tellus sed adipiscing dictum
            aliquet. Non in amet turpis fermentum varius. Semper molestie
            pharetra commodo bibendum sit et egestas ut.
          </p>
        </div>
      </div>
      <div class="about__benefits">
        <div class="about__benefit">
          <div class="about__benefit-icon">
            <x-icon src="icons/heart.svg" />
          </div>
          <div class="about__benefit-text">Преимущество первое</div>
        </div>
        <div class="about__benefit">
          <div class="about__benefit-icon">
            <x-icon src="icons/heart.svg" />
          </div>
          <div class="about__benefit-text">Преимущество первое</div>
        </div>
        <div class="about__benefit">
          <div class="about__benefit-icon">
            <x-icon src="icons/heart.svg" />
          </div>
          <div class="about__benefit-text">Преимущество третье</div>
        </div>
        <div class="about__benefit">
          <div class="about__benefit-icon">
            <x-icon src="icons/heart.svg" />
          </div>
          <div class="about__benefit-text">Преимущество четвертое</div>
        </div>
      </div>
    </div>
  </section>
</x-layouts.main>
