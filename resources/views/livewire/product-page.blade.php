<main class="product-page">
  {{-- хлебушек --}}
  <x-main.breadcrumbs :list="$breadcrumbs" />

  {{-- product --}}
  <section class="product product__section" wire:loading.class="loading">
    <div class="product__container container">
      {{-- gallery --}}
      <x-product.gallery :media="$product->media" />

      {{-- right details --}}
      <livewire:components.product-detail :product="$product->toArray()" />
    </div>
  </section>

  {{-- Популярные товары --}}
  <x-product.list
    title="C этим товаром покупают"
    :products="$similar"
    :button="['/catalog', 'В каталог']"
  />

  {{-- Отзывы --}}
  <livewire:lists.review-list
    title="Отзывы покупателей"
    :product_id="$product->id"
  />
</main>
