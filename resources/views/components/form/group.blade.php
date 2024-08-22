<div
  @isset($attributes["x-show"])
      x-show="{{ $attributes["x-show"] }}"
  @endisset
  class="{{ $attributes["class"] }}-group field-group"
  x-transition.scale.opacity.duration.300ms
>
  @isset($attributes["label"])
    <label
      @class([$attributes["class"] . "-label", "field-label", "required" => $attributes["required"] ?? false])
      for="{{ $attributes["id"] }}"
    >
      {{ $attributes["label"] }}
    </label>
  @endisset

  {{ $slot }}

  @isset($attributes["help"])
    <label
      class="{{ $attributes["class"] }}-help field-help"
      for="{{ $attributes["id"] }}"
    >
      {{ $attributes["help"] }}
    </label>
  @endisset
</div>
