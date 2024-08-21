<section @class(['categories__section', $className])>
  @if ($categories->isNotEmpty())
    <div class="categories__container container">
      @isset($pretitle, $title)
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
      @endisset

      @if ($swiper)
        <x-category.swiper :$categories :$className :$activeIndex />
      @else
        <div class="categories__list">
          @foreach ($categories as $category)
            <x-category.card
              :key="$category->id"
              :category="$category"
              :active="$activeIndex === $loop->index"
            />
          @endforeach
        </div>
      @endif
    </div>
  @endif
</section>
