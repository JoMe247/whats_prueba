<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Enviar WhatsApp</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-4">
    <h2 class="mb-4">Enviar mensaje WhatsApp</h2>

    <div class="mb-3">
      <a href="{{ route('whatsapp.inbox') }}" class="btn btn-secondary">📥 Ver Inbox</a>
    </div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
        </ul>
      </div>
    @endif

    <div class="card shadow-sm">
      <div class="card-body">
        <form action="{{ route('whatsapp.send.post') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label>Número destino (ej: +521XXXXXXXXXX)</label>
            <input type="text" name="to" class="form-control" required placeholder="+521XXXXXXXXXX" value="{{ old('to') }}">
          </div>
          <div class="mb-3">
            <label>Mensaje</label>
            <textarea name="body" class="form-control" rows="4" required>{{ old('body') }}</textarea>
          </div>
          <button class="btn btn-primary">Enviar por Twilio</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
