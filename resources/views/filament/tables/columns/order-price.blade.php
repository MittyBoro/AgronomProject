<div class="grid grid-cols-[auto_1fr] gap-y-1 text-sm">
  {{--  --}}
  <div class="flex items-baseline">
    <span>Начислено бонусов</span>
    <span class="w-full min-w-8 mx-2 border-b"></span>
  </div>
  <div class="max-w-base">
    {{ price_formatter($getRecord()->earned_amount) }}
    ({{ round(($getRecord()->earned_amount / $getRecord()->total_price) * 100, 2) }}%)
  </div>

  <div class="col-span-full mt-2"></div>

  {{--  --}}
  <div class="flex items-baseline">
    <span>Стоимость</span>
    <span class="w-full min-w-8 mx-2 border-b"></span>
  </div>
  <div class="max-w-base">{{ price_formatter($getRecord()->price) }}₽</div>

  {{--  --}}
  @if ($getRecord()->spent_amount)
    <div class="flex items-baseline">
      <span>Списано бонусов</span>
      <span class="w-full min-w-8 mx-2 border-b"></span>
    </div>
    <div class="max-w-base">
      {{ price_formatter($getRecord()->spent_amount) }}
      ({{ round(($getRecord()->spent_amount / $getRecord()->price) * 100, 2) }}%)
    </div>
  @endif

  {{--  --}}
  @if ($getRecord()->coupon)
    <div class="flex items-baseline">
      <span>Промокод</span>
      <span class="w-full min-w-8 mx-2 border-b"></span>
    </div>
    <div class="max-w-base">
      {{ price_formatter($getRecord()->coupon->percentage) }}%
      [{{ $getRecord()->coupon->code }}]
    </div>
  @endif

  @if ($getRecord()->discount)
    <div class="flex items-baseline">
      <span>Общая скидка</span>
      <span class="w-full min-w-8 mx-2 border-b"></span>
    </div>
    <div class="max-w-base">
      {{ price_formatter($getRecord()->discount) }}₽
      ({{ round(($getRecord()->discount / $getRecord()->total_price) * 100, 2) }}%)
    </div>
  @endif

  {{--  --}}
  <div class="flex items-baseline font-bold">
    <span>Итого</span>
    <span class="w-full min-w-8 mx-2 border-b"></span>
  </div>
  <div class="max-w-base font-bold">
    {{ price_formatter($getRecord()->total_price) }}₽
  </div>
</div>
