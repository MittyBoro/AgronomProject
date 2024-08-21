<section
  class="products products__section"
  id="paginated"
  wire:loading.class="loading"
>
  @if ($products->isNotEmpty())
    <div class="products__container container">
      <x-main.title
        :titleTag="$titleTag ?? 'h2'"
        :pretitle="$pretitle ?? null"
        :title="$title ?? null"
        :button="$button ?? null"
      >
        {{ $slot }}
      </x-main.title>
      <div class="products-list">
        @foreach ($products as $product)
          <livewire:components.product-card :key="$product->id" :$product />
          {{-- <x-product.card :$product /> --}}
        @endforeach
      </div>
      @if ($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="catalog__pagination pagination">
          {{ $products->links('components.main.pagination', data: ['scrollTo' => '#paginated']) }}
        </div>
      @endif
    </div>
  @else
    <div class="list__empty">
      <div class="list__empty-image">
        <x-main.icon src="icons/leaf.svg" />
      </div>
      <div class="list__empty-text">Здесь пока ничего нет</div>
      <a href="/catalog" class="button" wire:navigate>К покупкам</a>
    </div>
  @endif
</section>
