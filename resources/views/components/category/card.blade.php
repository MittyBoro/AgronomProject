<a href="/catalog/{{ $category->slug }}" title="{{ $category->title }}"
  :key="{{ $category->id }}" @class([
      'category__card',
      'category__card--active' => !empty($active),
  ])
  x-on:click.prevent="Livewire.navigate('/catalog/{{ $category->slug }}')">
  <span class="category__card-icon">
    <x-main.picture :media="$category->media->first()" />
  </span>

  <span class="category__card-name">{{ $category->title }}</span>
</a>
