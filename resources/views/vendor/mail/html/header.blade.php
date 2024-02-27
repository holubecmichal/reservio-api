@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
<img src="https://1874966808.rsc.cdn77.org/_next/static/media/logo.982c008d.svg" class="logo" alt="Reservio logo">
@endif
</a>
</td>
</tr>
