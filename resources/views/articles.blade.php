<x-layouts.main body_name="articles">
  <x-a.breadcrumbs :list="[['Программы подкормок', null]]" />

  {{-- articles --}}
  <section class="articles articles__section">
    <div class="articles__container container">
      <div class="articles__title title">
        <h2>Программы подкормок</h2>
      </div>
      <div class="articles__list">
        <!-- Article Items -->
        @foreach (range(1, 6) as $product)
          <x-articles.card />
        @endforeach

        <div class="articles__pagination pagination">
          <div class="button">Показать больше</div>
        </div>
      </div>
    </div>
  </section>
</x-layouts.main>
