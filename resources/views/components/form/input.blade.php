<x-form.group {{ $attributes }}>
  <input class="{{ $attributes['class'] }}-input field-input"
    id="{{ $attributes['id'] }}"
    name="{{ $attributes['name'] ?? $attributes['id'] }}"
    type="{{ $attributes['type'] ?? 'text' }}"
    value="{{ $attributes['value'] ?? '' }}"
    {{ $attributes['required'] ? 'required' : '' }} />
</x-form.group>
