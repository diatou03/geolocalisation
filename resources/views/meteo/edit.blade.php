@extends('layouts.app')

@section('content')
    <h1>Modifier la Donnée Météo</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('meteo.update', $donnee->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="localisation_id">Localisation :</label>
        <select name="localisation_id" id="localisation_id" required>
            @foreach($localisations as $localisation)
                <option value="{{ $localisation->id }}" {{ $donnee->localisation_id == $localisation->id ? 'selected' : '' }}>
                    {{ $localisation->nom }}
                </option>
            @endforeach
        </select>

        <label for="temperature">Température (°C) :</label>
        <input type="number" step="0.1" name="temperature" id="temperature" value="{{ old('temperature', $donnee->temperature) }}" required>

        <label for="humidite">Humidité (%) :</label>
        <input type="number" step="0.1" name="humidite" id="humidite" value="{{ old('humidite', $donnee->humidite) }}" required>

        <label for="pression">Pression (hPa) :</label>
        <input type="number" step="0.1" name="pression" id="pression" value="{{ old('pression', $donnee->pression) }}" required>

        <label for="description">Description :</label>
        <textarea name="description" id="description">{{ old('description', $donnee->description) }}</textarea>

        <label for="date_observation">Date d'Observation :</label>
        <input type="date" name="date_observation" id="date_observation" value="{{ old('date_observation', $donnee->date_observation) }}" required>

        <button type="submit">Mettre à Jour</button>
    </form>
@endsection
