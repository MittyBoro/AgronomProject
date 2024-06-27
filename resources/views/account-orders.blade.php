<x-layouts.account name="orders">
  <div class="account-orders">
    @foreach (range(1, 10) as $item)
      <x-account.order :item="$item" />
    @endforeach
  </div>
</x-layouts.account>
