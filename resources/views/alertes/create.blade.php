@extends('layouts.app')

@section('content')
<h2>Créer une Alerte manuellement</h2>
<form action="{{ route('alertes.store') }}" method="POST">
  @include('alertes.form')
  <button class="btn btn-success">Créer</button>
</form>
@endsection
