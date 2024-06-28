<div class="{{ $attributes['class'] }}-group field-group">
  @isset($attributes['label'])
    <label
      for="{{ $attributes['id'] }}"
      class="{{ $attributes['class'] }}-label field-label"
    >
      {{ $attributes['label'] }}
    </label>
  @endisset

  {{ $slot }}

  @isset($attributes['help'])
    <label
      for="{{ $attributes['id'] }}"
      class="{{ $attributes['class'] }}-help field-help"
    >
      {{ $attributes['help'] }}
    </label>
  @endisset
</div>
