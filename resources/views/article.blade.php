<x-layouts.main body_name="page" :page="$article">
  <x-a.breadcrumbs :list="[['Статьи', '/articles'], [$article->title, null]]" />
  {{--  --}}
  <section class="page__section">
    <div class="page__container container">
      <div class="page__title title">
        <h1>{{ $article->title }}</h1>
      </div>
      <div class="page__prose prose">
        {!! $article->content !!}
      </div>
    </div>
  </section>


  {{-- similar --}}
  @if ($similar->count())
    <section class="articles articles__similar articles__section">
      <div class="articles__container container">
        <div class="articles__subtitle subtitle">Полезное</div>
        <div class="articles__title title">
          <h2>Так же смотрят</h2>
          <a class="button articles__button" href="/articles">Посмотреть все</a>
        </div>
        <div class="articles__list">
          <!-- Article Items -->
          @foreach ($similar as $item)
            <x-articles.card :item="$item" />
          @endforeach
        </div>
      </div>
    </section>
  @endif
</x-layouts.main>
