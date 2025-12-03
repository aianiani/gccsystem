@props(['url'])

<table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="text-align: center;">
                <tr>
                    <td align="center">
                        <a href="{{ $url }}"
                           style="display: inline-block;
                                  padding: 12px 28px;
                                  border-radius: 999px;
                                  background-color: #2d5016;
                                  color: #ffffff !important;
                                  font-weight: 600;
                                  font-size: 14px;
                                  text-decoration: none;">
                            {{ $slot }}
                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
