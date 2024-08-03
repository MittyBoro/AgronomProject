<a class="category" href="/catalog/{{ $category->slug }}"
  title="{{ $category->title }}">
  <span class="category__icon">
    <x-a.picture :media="$category->media" />
  </span>

  <span class="category__name">{{ $category->title }}</span>
</a>
