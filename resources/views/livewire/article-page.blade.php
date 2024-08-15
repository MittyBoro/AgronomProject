<main class="article-page">
  {{-- хлебушек --}}
  <x-main.breadcrumbs :list="$breadcrumbs" />

  {{-- article --}}
  <section class="page__section">
    <div class="page__container container">
      <div class="page__title head-row__title">
        <h1>{{ $article->title }}</h1>
      </div>
      <div class="page__details">
        <span title="{{ $article->created_at }}">
          <x-main.icon src="icons/clock.svg" />
          {{ $article->created_at->diffForHumans() }}
        </span>
        @if ($article->views > 50)
          <span>
            <x-main.icon src="icons/eye.svg" />
            {{ Number::format($article->views) }}
          </span>
        @endif
      </div>
      <div class="page__prose prose">
        {!! $article->content !!}
      </div>
    </div>
  </section>

  {{-- Популярные товары --}}
  <x-article.list
    title="Так же смотрят"
    pretitle="Похожие"
    :articles="$similar"
    :button="['/articles', 'Посмотреть все']"
  />
</main>
