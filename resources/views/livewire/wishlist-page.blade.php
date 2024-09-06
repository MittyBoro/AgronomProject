<main class="wishlist-page">
  {{-- Товары --}}
  <x-product.list titleTag="h1" title="Избранное" :$products />

  {{-- недавно смотрели --}}
  <livewire:lists.recently-watched />
</main>
