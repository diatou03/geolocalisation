@extends('layouts.app')

@section('content')
<h2>Détails de l’Alerte</h2>
<ul class="list-group mb-3">
  <li class="list-group-item"><strong>Type :</strong> {{ ucfirst($alerte->type) }}</li>
  <li class="list-group-item"><strong>Message :</strong> {{ $alerte->message }}</li>
  <li class="list-group-item"><strong>Pirogue :</strong> {{ $alerte->pirogue->nom }}</li>
  <li class="list-group-item"><strong>Position :</strong> {{ $alerte->latitude }}, {{ $alerte->longitude }}</li>
  <li class="list-group-item"><strong>Envoyée :</strong> @if($alerte->envoyee) Oui @else Non @endif</li>
  <li class="list-group-item"><strong>Créée le :</strong> {{ $alerte->created_at->format('Y‑m‑d H:i') }}</li>
</ul>
<a href="{{ route('alertes.index') }}" class="btn btn-secondary">Retour</a>
<a href="{{ route('alertes.edit', $alerte) }}" class="btn btn-warning">Modifier</a>
@endsection
