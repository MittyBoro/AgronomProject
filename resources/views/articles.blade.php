<x-layouts.main :page="$page" body_name="articles">
  <x-a.breadcrumbs :list="[['Программы подкормок', null]]" />

  {{-- articles --}}
  <section class="articles articles__section">
    <div class="articles__container container">
      <div class="articles__title title">
        <h2>Программы подкормок</h2>
      </div>
      <div class="articles__list">
        <!-- Article Items -->
        @foreach ($articles as $item)
          <x-articles.card :item="$item" />
        @endforeach

        <div class="grid-col-full">
          {{ $articles->links('components.a.pagination') }}
        </div>
      </div>
    </div>
  </section>
</x-layouts.main>
