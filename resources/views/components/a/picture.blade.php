@php
  $item = $item ?? $media?->first();
  $i = isset($attributes['i']) ? ' (' . $attributes['i'] + 1 . ')' : '';
@endphp

@if ($item)
  @if ($item->hasResponsiveImages('jpeg'))
    <picture class="{{ $class ?? '' }}">
      <source srcset="{{ $item->getSrcset('webp') }}" type="image/webp" />
      <source srcset="{{ $item->getSrcset('jpeg') }}" type="image/jpeg" />
      <img srcset="{{ $item->getSrcset('jpeg') }}"
        src="{{ $item->responsiveImages('jpeg')->files->last()->url() }}"
        title="Изображение {{ $item->name . $i }}"
        alt="Фото {{ $item->name . $i }}"
        loading="{{ !isset($loading) ? 'lazy' : $loading }}"
        @if ($item->hasCustomProperty('width')) width="{{ $item->getCustomProperty('width') }}" @endif
        @if ($item->hasCustomProperty('height')) height="{{ $item->getCustomProperty('height') }}" @endif />
    </picture>
  @else
    <img src="{{ $item->getUrl() }}"
      title="Изображение {{ $item->name . $i }}"
      alt="Фото {{ $item->name . $i }}"
      loading="{{ !isset($loading) ? 'lazy' : $loading }}"
      @if ($item->hasCustomProperty('width')) width="{{ $item->getCustomProperty('width') }}" @endif
      @if ($item->hasCustomProperty('height')) height="{{ $item->getCustomProperty('height') }}" @endif />
  @endif
@endif
