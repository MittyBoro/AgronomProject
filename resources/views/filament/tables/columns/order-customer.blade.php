@php
  $gridData = [
    'ФИО' => 'full_name',
    'Email' => 'email',
    'Телефон' => 'phone',
    'Почтовый индекс' => 'postal_code',
    'Город' => 'city',
    'Адрес' => 'address',
    'Комментарий' => 'comment',
  ];
@endphp

<div class="grid grid-cols-[auto_1fr] gap-y-1 text-sm">
  @foreach ($gridData as $label => $column)
    @if ($getRecord()->{$column})
      <div class="flex items-baseline">
        <span>{{ $label }}</span>
        <span class="w-full min-w-8 mx-2 border-b"></span>
      </div>
      <div class="max-w-base whitespace-normal">
        {{ $getRecord()->{$column} }}
      </div>
    @endif
  @endforeach
</div>
