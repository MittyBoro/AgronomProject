<div class="article">
  <div class="article__image">
    <x-a.picture class="object-cover" :media="$item->media" />
  </div>
  <div class="article__text white-blur-block">
    <div class="article__name">{{ $item->title }}</div>
    <div class="article__description">
      {{ $item->description }}
    </div>
    <a class="article__link color-link" href="#">Смотреть</a>
  </div>
</div>
