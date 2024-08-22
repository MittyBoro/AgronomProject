<div class="{{ $attributes['class'] }}-checkbox-group field-checkbox-group">
  <input
    class="{{ $attributes['class'] }}-checkbox field-radio"
    id="{{ $attributes['id'] }}"
    name="{{ $attributes['name'] ?? $attributes['id'] }}"
    type="radio"
    value="{{ $attributes['value'] ?? '' }}"
    {{ $attributes['required'] ? 'required' : '' }}
  />
  <label
    class="{{ $attributes['class'] }}-checkbox-label field-checkbox-label"
    for="{{ $attributes['id'] }}"
  >
    {{ $attributes['label'] }}
    {{ $slot }}
  </label>
</div>
