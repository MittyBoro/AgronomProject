<div class="head-row">
  @isset($pretitle)
    <div class="head-row__pretitle">{{ $pretitle }}</div>
  @endisset
  <div class="head-row__title">
    <h2>{{ $title }}</h2>
    @if (!empty($button))
      <a class="button head-row__button" href="{{ $button[0] }}"
        wire:navigate>{{ $button[1] }}</a>
    @endif
    {{ $slot }}
  </div>
</div>
