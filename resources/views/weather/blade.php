{{-- resources/views/weather.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Application Météo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <h1 class="text-center mb-4">Application Météo</h1>

    {{-- Formulaire de recherche --}}
    <form method="GET" action="{{ route('weather.index') }}" class="row g-3 justify-content-center mb-4">
        <div class="col-md-4">
            <input type="text" name="city" id="city" class="form-control" placeholder="Entrez une ville" required value="{{ old('city') }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Rechercher</button>
        </div>
    </form>

    {{-- Affichage de la météo --}}
    @if (isset($weather))
        <div class="card mx-auto shadow-sm" style="max-width: 500px;">
            <div class="card-body text-center">
                <h3 class="card-title">Météo à {{ $weather['name'] }}</h3>

                @php
                    $iconCode = $weather['weather'][0]['icon'];
                    $iconUrl = "http://openweathermap.org/img/wn/{$iconCode}@2x.png";
                @endphp
                <img src="{{ $iconUrl }}" alt="Icône météo" class="mb-3">

                <p class="fs-5">🌡️ Température : <strong>{{ $weather['main']['temp'] }} °C</strong></p>
                <p>💧 Humidité : {{ $weather['main']['humidity'] }} %</p>
                <p>☁️ Description : {{ ucfirst($weather['weather'][0]['description']) }}</p>
            </div>
        </div>

    @elseif (isset($error))
        <div class="alert alert-danger text-center mt-4" role="alert">
            {{ $error }}
        </div>

    @else
        <div class="alert alert-info text-center mt-4" role="alert">
            Aucune donnée météo disponible.
        </div>
    @endif
</div>

</body>
</html>
