@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
  <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@isset($alerte)
  <form action="{{ route('alertes.send', $alerte) }}" method="POST">
    @csrf
    <button class="btn btn-sm btn-success">Marquer envoyée</button>
  </form>
@else
  <p class="text-warning">Aucune alerte sélectionnée.</p>
@endisset
