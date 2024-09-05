<span
  class="icon {{ $attributes['class'] ?? '' }}"
  style="--icon: url('{{ Vite::front($attributes['src']) }}')"
  @foreach (Arr::except($attributes, ["class", "src"]) as $k => $v)
      {{ $k }}="{{ $v }}"
  @endforeach
></span>
