<div
  class="article__card"
  onclick="Livewire.navigate('/articles/{{ $article->slug }}')"
>
  <div class="article__card-image">
    <x-main.picture class="object-cover" :media="$article->media->first()" />
  </div>
  <div class="article__card-text white-blur-block">
    <div class="article__card-name">{{ $article->title }}</div>
    <div class="article__card-description">
      {{ $article->description }}
    </div>
    <a
      class="article__card-link color-link"
      href="/articles/{{ $article->slug }}"
      wire:navigate
    >
      Смотреть
    </a>
  </div>
</div>
