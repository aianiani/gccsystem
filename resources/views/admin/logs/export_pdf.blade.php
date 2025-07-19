<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>All Logs Export</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { margin-top: 30px; color: #2d5016; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; }
        th { background: #e8f5e8; color: #2d5016; }
    </style>
</head>
<body>
    <h1>All Logs Export</h1>
    @foreach($users as $user)
        @php $userArr[] = $user->toArray(); @endphp
    @endforeach
    @foreach(['users','appointments','assessments','session_notes','session_feedbacks','messages','activities'] as $type)
        <h2>{{ ucfirst(str_replace('_',' ',$type)) }}</h2>
        @php $rows = $$type; @endphp
        @if(count($rows))
        <table>
            <thead>
            <tr>
                @foreach(array_keys($rows->first()->toArray()) as $col)
                    <th>{{ $col }}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($rows as $row)
                <tr>
                    @foreach($row->toArray() as $val)
                        <td>{{ is_array($val) ? json_encode($val) : $val }}</td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
        @else
            <p>No data.</p>
        @endif
    @endforeach
</body>
</html> 