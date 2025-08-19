<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>WA (API)</title>
    <style>
        table { border-collapse: collapse; width: 100% }
        td, th { border: 1px solid #ccc; padding: 6px }
        th { background: #f4f4f4 }
        code { background: #f8f8f8; border: 1px solid #eee; padding: 1px 4px }
    </style>
</head>
<body>
    <h1>Mensajes (API) — hacia {{ $fromWa }}</h1>
    <table>
        <tr>
            <th>Fecha</th>
            <th>From</th>
            <th>To</th>
            <th>Body</th>
            <th>Direction</th>
            <th>SID</th>
        </tr>
        @foreach ($messages as $m)
            @if ($m->direction === 'inbound')
                <tr>
                    <td>{{ optional($m->dateSent ?: $m->dateCreated)->format('Y-m-d H:i:s') }}</td>
                    <td>{{ $m->from }}</td>
                    <td>{{ $m->to }}</td>
                    <td>{!! nl2br(e($m->body)) !!}</td>
                    <td>{{ $m->direction }}</td>
                    <td><code>{{ $m->sid }}</code></td>
                </tr>
            @endif
        @endforeach
    </table>
</body>
</html>
