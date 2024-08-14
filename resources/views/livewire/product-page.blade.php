<main class="product-page">
  {{-- хлебушек --}}
  <x-main.breadcrumbs :list="$breadcrumbs" />


  {{-- product --}}
  <section class="product product__section">
    <div class="product__container container">
      {{-- gallery --}}
      <x-swiper.product-gallery :media="$product->media" />

      {{-- right details --}}
      <livewire:product.detail :product="$product->toArray()" />
    </div>
  </section>

  {{-- Отзывы --}}
  <livewire:lists.review-list title="Отзывы покупателей" :product_id="$product->id" />

  {{-- Популярные товары --}}
  <x-product.list title="C этим товаром покупают" pretitle="Похожие"
    :products="$similar" :button="['/catalog', 'В каталог']" />
</main>
