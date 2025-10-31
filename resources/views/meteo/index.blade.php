@extends('layouts.app')

@section('content')
    <h1>Données Météo</h1>
    <a href="{{ route('meteo.create') }}">Ajouter une nouvelle donnée</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>ville</th>
                <th>Température (°C)</th>
                <th>Humidité (%)</th>
                <th>Pression (hPa)</th>
                <th>Vitesse du vent (km/h)</th>
                <th>Direction du vent (°)</th>
                <th>Description</th>
                <th>Heure</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($meteo as $donnee)
                <tr>
                    <td>{{ $donnee->ville->nom }}</td>
                    <td>{{ $donnee->temperature }}</td>
                    <td>{{ $donnee->humidite }}</td>
                    <td>{{ $donnee->pression }}</td>
                     <td>{{$donnee->vitesse_vent }}</td>
                    <td>{{ $donnee->direction_vent ?? 'N/A' }}</td>
                    <td>{{ $donnee->description }}</td>
                    <td>{{ $donnee->heure_prévision }}</td>
                    <td>
                        <a href="{{ route('meteo.edit', $donnee->id) }}">Modifier</a>
                        <form action="{{ route('meteo.destroy', $donnee->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection


