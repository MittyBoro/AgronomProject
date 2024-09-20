<x-form.group {{ $attributes }}>
  <input
    class="{{ $attributes["class"] }}-input field-input"
    name="{{ $attributes["name"] ?? $attributes["id"] }}"
    type="{{ $attributes["type"] ?? "text" }}"
    {{--  --}}
    @if ($attributes["type"] === "tel" && empty($attributes["x-mask"]))
        @if (empty($attributes["placeholder"]))
            placeholder="+7 ___ ___ __ __"
        @endif
        x-mask="+7 999 999 99 99"
        pattern="\+7\s\d{3}\s\d{3}\s\d{2}\s\d{2}"
        x-on:input="
            (event.target.value.startsWith('+7 8') ||
                event.target.value.startsWith('+7 7')) &&
                (event.target.value = event.target.value.replace(/^\+7\s[87]/, '+7 '))
        "
    @endif
    {{--  --}}
    @foreach (Arr::except($attributes, [
            "class",
            "name",
            "type",
            "x-show",
            "label",
            "help"
        ])
        as $k => $v)
        @if ($v !== false)
            {{ $k }}="{{ $v }}"
        @endif
    @endforeach
  />
</x-form.group>
