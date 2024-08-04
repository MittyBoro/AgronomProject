@forelse  ($products as $item)
  <x-products.card :item="$item" />
@empty
  <div class="col-full white-box event-links">
    <div class="white-item">
      <div class="h2 tac">Не найдено</div>
      <a class="btn" href="{{ route('front.pages', 'catalog') }}">В
        каталог</a>
    </div>
  </div>
@endforelse

@if ($products->hasPages())
  <div class="catalog-pagination event-links" id="catalog_pagination">
    @if ($products->hasMorePages())
      <a class="catalog__pagination pagination more"
        href="{{ $products->nextPageUrl() }}">
        <div class="button">Показать больше</div>
      </a>
    @endif
  </div>
@endif
