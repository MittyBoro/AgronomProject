<div>
  <div class="profile-orders">
    @foreach (range(1, 10) as $item)
      <x-profile.order :item="$item" />
    @endforeach
  </div>
</div>
