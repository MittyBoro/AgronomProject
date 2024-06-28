<x-form.group {{ $attributes }}>
  <input
    id="{{ $attributes['id'] }}"
    class="{{ $attributes['class'] }}-input field-input"
    type="{{ $attributes['type'] ?? 'text' }}"
    name="{{ $attributes['name'] ?? $attributes['id'] }}"
    value="{{ $attributes['value'] ?? '' }}"
    {{ $attributes['required'] ? 'required' : '' }}
  />
</x-form.group>
