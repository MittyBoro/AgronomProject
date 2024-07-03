<x-form.group {{ $attributes }}>
  <textarea class="{{ $attributes['class'] }}-input field-textarea"
    id="{{ $attributes['id'] }}"
    name="{{ $attributes['name'] ?? $attributes['id'] }}"
    {{ $attributes['required'] ? 'required' : '' }}
    rows="{{ $attributes['rows'] ?? 1 }}">
 {{ $attributes['value'] ?? '' }}
 </textarea>
</x-form.group>
