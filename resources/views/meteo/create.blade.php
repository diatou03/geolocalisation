@extends('layouts.app')

@section('content')
    <h1>Ajouter une Nouvelle Donnée Météo</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('meteo.store') }}" method="POST">
        @csrf
        <label for="localisation_id">Localisation :</label>
        <select name="localisation_id" id="localisation_id" required>
            @foreach($localisations as $localisation)
                <option value="{{ $localisation->id }}">{{ $localisation->nom }}</option>
            @endforeach
        </select>

        <label for="temperature">Température (°C) :</label>
        <input type="number" step="0.1" name="temperature" id="temperature" value="{{ old('temperature') }}" required>

        <label for="humidite">Humidité (%) :</label>
        <input type="number" step="0.1" name="humidite" id="humidite" value="{{ old('humidite') }}" required>

        <label for="pression">Pression (hPa) :</label>
        <input type="number" step="0.1" name="pression" id="pression" value="{{ old('pression') }}" required>

        <label for="description">Description :</label>
        <textarea name="description" id="description">{{ old('description') }}</textarea>

        <label for="date_observation">Date d'Observation :</label>
        <input type="date" name="date_observation" id="date_observation" value="{{ old('date_observation') }}" required>

        <button type="submit">Enregistrer</button>
    </form>
@endsection
