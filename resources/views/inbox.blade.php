<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inbox WhatsApp</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-4">
    <h2 class="mb-4">Inbox / Historial</h2>

    <div class="mb-3">
      <a href="{{ route('whatsapp.send') }}" class="btn btn-success">✉️ Enviar mensaje</a>
    </div>

    <div class="card shadow-sm">
      <div class="card-body">
        <table class="table table-sm table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Dirección</th>
              <th>Desde</th>
              <th>Para</th>
              <th>Mensaje</th>
              <th>Fecha</th>
            </tr>
          </thead>
          <tbody>
            @forelse($messages as $m)
              <tr>
                <td>{{ $m->id }}</td>
                <td>{{ $m->direction }}</td>
                <td>{{ $m->from }}</td>
                <td>{{ $m->to }}</td>
                <td style="max-width:400px;white-space:pre-wrap;">{{ $m->body }}</td>
                <td>{{ $m->received_at ? $m->received_at->format('Y-m-d H:i:s') : $m->created_at->format('Y-m-d H:i:s') }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center text-muted">No hay mensajes</td>
              </tr>
            @endforelse
          </tbody>
        </table>

        <div>
          {{ $messages->links() }}
        </div>
      </div>
    </div>
  </div>
</body>
</html>
