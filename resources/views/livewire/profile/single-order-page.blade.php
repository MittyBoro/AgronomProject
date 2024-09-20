<div class="profile-orders">
  <div class="profile-index__orders-title profile__title">
    <a href="{{ route('profile.orders.index') }}" wire:navigate>
      <x-main.icon src="icons/arrow.svg" />
      <span>Ко всем заказам</span>
    </a>
  </div>

  <x-profile.order :$order :open="true" />
</div>
