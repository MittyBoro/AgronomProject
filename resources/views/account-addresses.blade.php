<x-layouts.account>
  <x-slot:top>
    <x-breadcrumbs
      :list="[['Мой профиль', 'account-index'], ['Адреса', null]]"
    />
  </x-slot>
  <div class="account-addresses">
    @foreach (range(1, 3) as $item)
      <x-addresses.card :item="$item" />
    @endforeach

    <div class="account-addresses__button button button-alt">
      <x-icon src="icons/plus.svg" />
      Добавить адрес
    </div>
  </div>
</x-layouts.account>
