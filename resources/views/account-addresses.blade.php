<x-layouts.account name="addresses">
  <div class="account-addresses">
    @foreach (range(1, 3) as $item)
      <x-account.address :item="$item" />
    @endforeach

    <div class="account-addresses__button button button-alt">
      <x-a.icon src="icons/plus.svg" />
      Добавить адрес
    </div>
  </div>
</x-layouts.account>
