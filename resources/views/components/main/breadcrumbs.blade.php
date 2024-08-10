@props(['list'])
<div class="breadcrumbs">
  <div class="breadcrumbs__container container">
    <a class="breadcrumbs__item link" href="/">Главная</a>
    @foreach ($list as [$name, $link])
      <span class="breadcrumbs__item">/</span>

      @isset($link)
        <a class="breadcrumbs__item link"
          href="{{ $link }}">{{ $name }}</a>
      @else
        <span class="breadcrumbs__item">{{ $name }}</span>
      @endisset
    @endforeach
  </div>
</div>
