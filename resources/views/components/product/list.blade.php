  <section class="products products__section" id="paginated"
    wire:loading.class="loading">
    <div class="products__container container">
      <x-main.title :pretitle="$pretitle ?? null" :title="$title ?? null" :button="$button ?? null">
        {{ $slot }}
      </x-main.title>
      <div class="products-list">
        @foreach ($products as $product)
          {{-- <livewire:lists.product-card :$product /> --}}
          <x-product.card :$product />
        @endforeach
      </div>
      @if ($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="catalog__pagination pagination" id="catalog_pagination">
          {{ $products->links('components.main.pagination', data: ['scrollTo' => '#paginated']) }}
        </div>
      @endif
    </div>
  </section>
