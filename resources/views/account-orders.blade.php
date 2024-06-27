<x-layouts.account>
  <x-slot:top>
    <x-breadcrumbs
      :list="[['Мой профиль', 'account-index'], ['Заказы', null]]"
    />
  </x-slot>
  <div class="account-orders">
    @foreach (range(1, 10) as $item)
      <x-orders.card :item="$item" />
    @endforeach
  </div>
</x-layouts.account>
