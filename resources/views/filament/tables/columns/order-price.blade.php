<div class="grid grid-cols-[auto_1fr] gap-y-1 text-sm">
  {{--  --}}
  <div class="flex items-baseline">
    <span>Стоимость</span>
    <span class="w-full min-w-8 mx-2 border-b"></span>
  </div>
  <div class="max-w-base">{{ price_formatter($getRecord()->price) }}₽</div>

  {{--  --}}
  <div class="flex items-baseline">
    <span>Списано бонусов</span>
    <span class="w-full min-w-8 mx-2 border-b"></span>
  </div>
  <div class="max-w-base">
    {{ price_formatter($getRecord()->total_price) }}₽
  </div>

  {{--  --}}
  <div class="flex items-baseline">
    <span>Промокод</span>
    <span class="w-full min-w-8 mx-2 border-b"></span>
  </div>
  <div class="max-w-base">
    {{ price_formatter($getRecord()->total_price) }}₽
  </div>

  {{--  --}}
  <div class="flex items-baseline font-bold">
    <span>Итого</span>
    <span class="w-full min-w-8 mx-2 border-b"></span>
  </div>
  <div class="max-w-base font-bold">
    {{ price_formatter($getRecord()->total_price) }}₽
  </div>
</div>
