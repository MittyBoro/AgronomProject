<div>
  <div class="profile-orders" id="paginated">
    @foreach ($items as $item)
      <x-profile.order :order="$item" />
    @endforeach

    @if ($items instanceof \Illuminate\Pagination\LengthAwarePaginator)
      <div class="pagination">
        {{ $items->links('components.main.pagination', data: ['scrollTo' => '#paginated']) }}
      </div>
    @endif
  </div>
</div>
