<main class="simple-page">
  {{-- хлебушек --}}
  <x-main.breadcrumbs :list="$breadcrumbs" />

  {{-- article --}}
  <section class="page__section">
    <div class="page__container container">
      <div class="page__title head-row__title">
        <h1>{{ $page->title }}</h1>
      </div>
      <div class="page__prose prose">
        {!! $page->content !!}
      </div>
    </div>
  </section>
</main>
