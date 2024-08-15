<div class="breadcrumbs">
  <div class="breadcrumbs__container container">
    <a class="breadcrumbs__item link" href="/" wire:navigate>Главная</a>
    @foreach ($list as [$link, $name])
      <span class="breadcrumbs__item">/</span>

      @if ($link && ! $loop->last)
        <a class="breadcrumbs__item link" href="{{ $link }}" wire:navigate>
          {{ $name }}
        </a>
      @else
        <span class="breadcrumbs__item">{{ $name }}</span>
      @endif
    @endforeach
  </div>
</div>
