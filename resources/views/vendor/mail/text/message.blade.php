{{ $slot }}

@if(isset($subcopy))
---
{{ $subcopy }}
@endif

© {{ date('Y') }} {{ config('app.name') }}
