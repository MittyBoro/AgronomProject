<x-form.group {{ $attributes }}>
  <textarea
    class="{{ $attributes['class'] }}-input field-textarea"
    name="{{ $attributes['name'] ?? $attributes['id'] }}"
    {{ $attributes["required"] ? "required" : "" }}
    @foreach (Arr::except(
            [...$attributes],
            ["class", "name", "type", "x-show", "label", "help", "value"]
        )
        as $k => $v)
        @if ($v !== false)
            {{ $k }}="{{ $v }}"
        @endif
    @endforeach
  >
 {{ $attributes["value"] ?? "" }}
 </textarea
  >
</x-form.group>
