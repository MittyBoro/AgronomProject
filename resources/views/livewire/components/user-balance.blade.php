<span @class([$class => $balance])>
  @if ($balance)
    {{ $mini && $balance > 999 ? '999+' : price_formatter($balance) }}
  @endif
</span>
