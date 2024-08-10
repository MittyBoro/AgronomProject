<a class="category__card" href="/catalog/{{ $category->slug }}"
  title="{{ $category->title }}">
  <span class="category__card-icon">
    <x-main.picture :media="$category->media->first()" />
  </span>

  <span class="category__card-name">{{ $category->title }}</span>
</a>
