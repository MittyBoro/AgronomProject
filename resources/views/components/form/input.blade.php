<x-form.group {{ $attributes }}>
  <input
    class="{{ $attributes['class'] }}-input field-input"
    name="{{ $attributes['name'] ?? $attributes['id'] }}"
    type="{{ $attributes['type'] ?? 'text' }}"
    @foreach (Arr::except($attributes, [
            "class",
            "name",
            "type",
            "x-show",
            "label",
            "help"
        ])
        as $k => $v)
        {{ $k }}="{{ $v }}"
    @endforeach
  />
</x-form.group>
