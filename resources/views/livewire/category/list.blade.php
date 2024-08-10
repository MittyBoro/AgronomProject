<section class="categories__section {{ $className }}">
  <div class="categories__container container">
    <x-main.title :pretitle="$pretitle ?? null" :title="$title ?? null">
      @if ($swiper)
        <div class="nav-arrows">
          <div class="nav-arrow nav-arrow__prev">
            <x-main.icon src="icons/arrow.svg" />
          </div>
          <div class="nav-arrow nav-arrow__next">
            <x-main.icon src="icons/arrow.svg" />
          </div>
        </div>
      @endif
    </x-main.title>
    @if ($swiper)
      <x-category.swiper :$categories :$className />
    @else
      <div class="categories__list">
        @foreach ($categories as $category)
          <x-category.card :category="$category" />
        @endforeach
      </div>
    @endif
  </div>
</section>
