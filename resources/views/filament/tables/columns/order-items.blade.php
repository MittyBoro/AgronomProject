@use(Filament\Infolists\Components\SpatieMediaLibraryImageEntry)
<div class="text-sm w-full">
  <div class="text-base font-bold mb-4">
    Состав заказа
    ({{ $getRecord()->items->sum(fn ($item) => $item->quantity) }} шт.)
  </div>

  @foreach ($getRecord()->items as $item)
    <div
      class="grid grid-cols-[min-content_1fr_min-content_min-content] gap-x-5 py-2 px-4 -mx-4 items-center even:bg-gray-400/5"
    >
      {{-- @dump($item->product_title) --}}
      <div class="w-8 h-8 bg-gray-200 rounded-md overflow-hidden">
        <img src="{{ $item->media?->getUrl() }}" alt="" />
      </div>
      <div class="grid">
        <a
          href="{{ route('filament.theadmin.resources.products.edit', $item->product_id) }}"
          class="font-bold hover:underline"
        >
          {{ $item->product_title }}
        </a>
        <p class="text-gray-500">{{ $item->variant_title }}</p>
      </div>
      <div class="whitespace-nowrap opacity-70">
        {{ $item->quantity }} × {{ price_formatter(round($item->price)) }} ₽
      </div>
      <div class="whitespace-nowrap font-bold">
        {{ price_formatter(round($item->price * $item->quantity)) }} ₽
      </div>
    </div>
  @endforeach
</div>
