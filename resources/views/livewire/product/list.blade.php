  <section class="products products__section">
    <div class="products__container container">
      <x-main.title :pretitle="$pretitle ?? null" :title="$title ?? null" :button="$button ?? null" />
      <div class="products__products products-list">
        @foreach ($products as $product)
          <livewire:lists.product-card :$product />
        @endforeach
      </div>
    </div>
  </section>
