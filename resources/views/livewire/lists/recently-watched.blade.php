<div style="margin-top: var(--section-margin)">
  @if ($items?->isNotEmpty())
    <x-product.list title="Вы недавно смотрели" :products="$items" />
  @endif
</div>
