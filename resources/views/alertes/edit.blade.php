@extends('layouts.app')

@section('content')
<h2>Modifier l’Alerte</h2>
<form action="{{ route('alertes.update', $alerte) }}" method="POST">
  @csrf @method('PUT')
  @include('alertes.form')
  <button class="btn btn-primary">Enregistrer</button>
</form>
@endsection
