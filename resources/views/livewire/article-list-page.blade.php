<main class="catalog-page">
  {{-- хлебушек --}}
  <x-main.breadcrumbs :list="$breadcrumbs" />

  {{-- Товары --}}
  <x-article.list titleTag="h1" :$title :$articles></x-article.list>
</main>
