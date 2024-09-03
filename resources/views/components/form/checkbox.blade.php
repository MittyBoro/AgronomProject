<div class="{{ $attributes['class'] }}-checkbox-group field-checkbox-group">
  <input
    class="{{ $attributes['class'] }}-checkbox field-checkbox"
    name="{{ $attributes['name'] ?? $attributes['id'] }}"
    type="checkbox"
    @foreach (Arr::except(
            [...$attributes],
            ["class", "name", "type", "x-show", "label", "help"]
        )
        as $k => $v)
        @if ($v !== false)
            {{ $k }}="{{ $v }}"
        @endif
    @endforeach
  />
  <label
    class="{{ $attributes['class'] }}-checkbox-label field-checkbox-label"
    for="{{ $attributes['id'] }}"
  >
    {{ $attributes["label"] }}
    {{ $slot }}
  </label>
</div>
