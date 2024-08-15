<section class="articles__section" id="articles" wire:loading.class="loading">
  @if ($articles->isNotEmpty())
    <div class="articles__container container">
      <x-main.title
        :pretitle="$pretitle ?? null"
        :title="$title ?? null"
        :button="$button ?? null"
      />
      <div class="articles__list">
        @foreach ($articles as $article)
          <x-article.card :$article />
        @endforeach
      </div>
      @if ($articles instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="catalog__pagination pagination">
          {{ $articles->links('components.main.pagination', data: ['scrollTo' => '#articles']) }}
        </div>
      @endif
    </div>
  @endif
</section>
