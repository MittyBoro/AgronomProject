<div class="{{ $attributes['class'] }}-checkbox-group field-checkbox-group">
  <input
    id="{{ $attributes['id'] }}"
    class="{{ $attributes['class'] }}-checkbox field-checkbox"
    type="checkbox"
    name="{{ $attributes['name'] ?? $attributes['id'] }}"
    value="{{ $attributes['value'] ?? '' }}"
    {{ $attributes['required'] ? 'required' : '' }}
  />
  <label
    for="{{ $attributes['id'] }}"
    class="{{ $attributes['class'] }}-checkbox-label field-checkbox-label"
  >
    {{ $attributes['label'] }}
    {{ $slot }}
  </label>
</div>
