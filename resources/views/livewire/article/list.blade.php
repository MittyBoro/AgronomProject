  <section class="articles__section">
    <div class="article-list__container container">
      <x-main.title :pretitle="$pretitle ?? null" :title="$title ?? null" :button="$button ?? null" />
      <div class="articles__list">
        @foreach ($articles as $article)
          <x-article.card :$article />
        @endforeach
      </div>
    </div>
  </section>
