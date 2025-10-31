@extends('layouts.public')

@section('title', 'Accueil | Nap Ak Karangue')

@section('content')
<div class="text-center my-5">
    <h1 class="mb-4">🌊 Nap Ak Karangue</h1>
    <p class="lead mb-5">
        Bienvenue sur la plateforme de sécurité en mer.<br>
        Consultez la <strong>météo</strong> et les <strong>marées</strong> selon votre commune.
    </p>

    {{-- Formulaire météo --}}
    <form class="d-flex justify-content-center mb-4" method="GET" action="{{ route('weather.show') }}">
        <input type="text" name="city" class="form-control me-2" placeholder="Entrez une ville" value="{{ $city ?? 'Dakar' }}" style="max-width: 300px;">
        <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-cloud-sun me-1"></i> Voir la météo
        </button>
    </form>

    {{-- Bouton vers page marées --}}
    <div class="d-flex justify-content-center gap-3 flex-wrap mt-4">
        <a href="{{ route('tides.index') }}" class="btn btn-info btn-lg text-white">
            <i class="fa-solid fa-water me-2"></i> Marées par commune
        </a>
    </div>
</div>

{{-- Météo --}}
<div class="my-5">
    <h3 class="text-center mb-4">Météo à {{ ucfirst($city ?? 'Dakar') }}</h3>

    @if(!empty($weather['weather'][0]))
        @php
            $icon = $weather['weather'][0]['icon'] ?? '01d';
            $desc = ucfirst($weather['weather'][0]['description'] ?? '');
        @endphp
        <div class="text-center">
            <p><strong>{{ $desc }}</strong></p>
            <p>🌡️ Température : {{ $weather['main']['temp'] ?? '?' }} °C</p>
            <p>💧 Humidité : {{ $weather['main']['humidity'] ?? '?' }} %</p>
            <p>💨 Vent : {{ $weather['wind']['speed'] ?? '?' }} km/h</p>
            <p>🧭 Pression : {{ $weather['main']['pressure'] ?? '?' }} hPa</p>
            <p><img src="https://openweathermap.org/img/wn/{{ $icon }}@2x.png" alt="Météo"></p>
        </div>
    @else
        <p class="text-center text-danger">
            Impossible de récupérer la météo pour {{ ucfirst($city ?? 'Dakar') }}.
        </p>
    @endif
</div>

{{-- Carte --}}
<div class="my-5">
    <h3 class="text-center mb-4">Carte sommaire des alertes et positions</h3>
    <div id="map" style="height:400px; width:100%; border-radius:0.5rem;"></div>
</div>
@endsection

@section('scripts')
<script>
var map = L.map('map').setView([{{ $lat ?? 14.6928 }}, {{ $lon ?? -17.4467 }}], 8);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

L.marker([{{ $lat ?? 14.6928 }}, {{ $lon ?? -17.4467 }}]).addTo(map)
    .bindPopup('{{ ucfirst($city ?? "Dakar") }}')
    .openPopup();
</script>
@endsection
