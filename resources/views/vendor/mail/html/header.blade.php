@props(['url'])

<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td class="header" style="padding: 24px 0; text-align: center;">
            <a href="{{ $url }}" style="color: #f4d03f; font-size: 18px; font-weight: 700; text-decoration: none;">
                {{ $slot ?? config('app.name', 'GCC System') }}
            </a>
        </td>
    </tr>
</table>
