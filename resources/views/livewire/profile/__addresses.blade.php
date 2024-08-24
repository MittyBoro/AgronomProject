<x-layouts.account name="addresses">
  <div class="profile-addresses">
    @foreach (range(1, 3) as $item)
      <x-profile.address :item="$item" />
    @endforeach

    <div class="profile-addresses__button button button-alt">
      <x-a.icon src="icons/plus.svg" />
      Добавить адрес
    </div>
  </div>
</x-layouts.account>
