@if ($errors->any())
  <div class="error__message prose" {{ $attributes }}>
    @foreach ($errors->all() as $error)
      <p>{{ $error }}</p>
    @endforeach
  </div>
@endif
