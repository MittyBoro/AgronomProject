<x-form.group {{ $attributes }}>
  <textarea
    id="{{ $attributes['id'] }}"
    class="{{ $attributes['class'] }}-input field-textarea"
    {{ $attributes['required'] ? 'required' : '' }}
    rows="{{ $attributes['rows'] ?? 1 }}"
    name="{{ $attributes['name'] ?? $attributes['id'] }}"
  >
 {{ $attributes['value'] ?? '' }}
 </textarea
  >
</x-form.group>
