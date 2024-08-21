<main class="wishlist-page">
  {{-- хлебушек --}}
  <x-main.breadcrumbs :list="$breadcrumbs" />

  {{-- Товары --}}
  <x-product.list titleTag="h1" title="Избранное" :$products />
</main>
