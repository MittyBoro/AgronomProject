<swiper-container class="product__slider" pagination="true"
  pagination-clickable="true" space-between="30px" loop="true" keyboard="true">
  @foreach ($media->sortBy('order_column') as $item)
    <swiper-slide>
      <div class="product__image">
        <x-main.picture class="object-cover" :media="$item" />
      </div>
    </swiper-slide>
  @endforeach
</swiper-container>
