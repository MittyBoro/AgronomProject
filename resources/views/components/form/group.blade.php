<div class="{{ $attributes['class'] }}-group field-group">
  @isset($attributes['label'])
    <label class="{{ $attributes['class'] }}-label field-label"
      for="{{ $attributes['id'] }}">
      {{ $attributes['label'] }}
    </label>
  @endisset

  {{ $slot }}

  @isset($attributes['help'])
    <label class="{{ $attributes['class'] }}-help field-help"
      for="{{ $attributes['id'] }}">
      {{ $attributes['help'] }}
    </label>
  @endisset
</div>
