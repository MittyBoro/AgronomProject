<main class="about-page">
  {{-- хлебушек --}}
  <x-main.breadcrumbs :list="$breadcrumbs" />

  <section class="about__section">
    <div class="about__container container">
      <div class="about__image">
        <img
          src="{{ Vite::front('images/logo.svg') }}"
          alt="{{ config('app.name') }}"
        />
      </div>
      <div class="about__text">
        <x-main.title titleTag="h1" pretitle="О нас" title="Наша компания" />
        <div class="about__prose prose">
          {!! $page->content !!}
        </div>
      </div>
      @if (! empty($benefits))
        <div class="about__benefits">
          @foreach ($benefits as $value)
            <div class="about__benefit">
              <div class="about__benefit-icon">
                <x-main.icon src="icons/logo.svg" />
              </div>
              <div class="about__benefit-text">{{ $value }}</div>
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </section>
</main>
