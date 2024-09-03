<span @class([$class => $balance])>
  @if ($balance)
    {{ price_formatter($balance) }}
  @endif
</span>
