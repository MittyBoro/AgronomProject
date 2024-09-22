@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
<img src="{{ Vite::front('images/logo-big.svg') }}" class="logo" alt="{{ config('app.name') }}">
</a>
</td>
</tr>
