@extends('layouts.public')

@section('title', 'Accueil | Nap Ak Karangue')

@section('styles')
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f0f4f8;
    margin: 0;
    padding: 0;
}

/* En-tête */
.header-home {
    text-align: center;
    margin-top: 50px;
}
.header-home h1 {
    font-size: 2.5rem;
    margin-bottom: 15px;
    color: #004b8d;
}
.header-home p {
    font-size: 1.2rem;
    color: #333;
}

/* Barre de recherche + bouton marée */
.search-form-home {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}
.search-form-home input {
    padding: 9px 15px;
    border-radius: 50px;
    border: 1px solid #ccc;
    width: 350px;
}
.search-form-home button,
.btn-tides {
    padding: 10px 20px;
    border-radius: 50px;
    border: none;
    background-color: #0056b3;
    color: white;
    cursor: pointer;
    transition: 0.3s;
}
.search-form-home button:hover,
.btn-tides:hover {
    background-color: #003f7f;
}
.btn-tides {
    background-color: white;
    border: 1px solid #0056b3;
    color: #0056b3;
}
.btn-tides:hover {
    background-color: #0056b3;
    color: white;
}

/* Grilles météo */
.weather-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 20px;
    margin-top: 20px;
    text-align: center;
}
.weather-box {
    background-color: #f8faff;
    border: 1px solid #d3e0ff;
    border-radius: 15px;
    padding: 15px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.weather-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}
.weather-box .icon {
    font-size: 40px;
    color: #0056b3;
    margin-bottom: 10px;
}
.weather-box h4 { font-size: 16px; color: #333; }
.weather-box p { font-size: 14px; color: #555; }

/* Carte */
#map {
    border-radius: 0.5rem;
    height: 400px;
    width: 100%;
    box-shadow: 0 3px 10px rgba(0,0,0,0.2);
}

/* Responsive */
@media (max-width:480px){
    .search-form-home input { width: 180px; }
    .btn-tides { width: 100%; justify-content: center; }
}
</style>
@endsection

@section('content')
<div class="container my-5">
    {{-- <h1 class="text-center mb-4">🌊 Nap Ak Karangue</h1> --}}

    <!--  Formulaire de recherche + bouton marées -->
    <form method="GET" action="{{ route('welcome') }}" class="search-form-home">
        <input type="text" name="city" class="form-control" placeholder="Entrez une ville (ex: Dakar)"
               value="{{ $city ?? '' }}">
        <button class="btn btn-primary" type="submit">Rechercher</button>
        <a href="{{ route('tides.index') }}" class="btn-tides"> Marées par commune</a>
    </form>

    <!--  Onglets météo -->
    <div class="text-center mb-4">
        <button class="btn btn-outline-primary {{ $type === 'current' ? 'active' : '' }}" onclick="showTab('current')">
            ☀️ Météo actuelle
        </button>
        <button class="btn btn-outline-primary {{ $type === 'forecast' ? 'active' : '' }}" onclick="showTab('forecast')">
            📅 Prévisions 3 jours
        </button>
    </div>

    <!--  Météo actuelle -->
    @if($type === 'current' && $weather)
    <div class="card shadow p-4 mx-auto" style="max-width: 800px;">
        <h3 class="text-center mb-3">{{ ucfirst($city) }}</h3>

        <div class="text-center">
            <img src="https://openweathermap.org/img/wn/{{ $weather['weather'][0]['icon'] }}@2x.png" alt="icon">
            <h4>{{ ucfirst($weather['weather'][0]['description']) }}</h4>
            <h2>{{ round($weather['main']['temp']) }}°C</h2>
        </div>

        <div class="weather-info-grid mt-4">
            <div class="weather-box">
                <div class="icon">🌡️</div>
                <h4>Température ressentie</h4>
                <p>{{ round($weather['main']['feels_like']) }}°C</p>
            </div>
            <div class="weather-box">
                <div class="icon">💨</div>
                <h4>Vent</h4>
                <p>{{ $weather['wind']['speed'] }} m/s</p>
            </div>
            <div class="weather-box">
                <div class="icon">🌡️</div>
                <h4>Pression</h4>
                <p>{{ $weather['main']['pressure'] }} hPa</p>
            </div>
            <div class="weather-box">
                <div class="icon">💧</div>
                <h4>Humidité</h4>
                <p>{{ $weather['main']['humidity'] }}%</p>
            </div>
        </div>
    </div>
    @endif

 <!--  Prévisions météo -->
@if(isset($weather['list']) && count($weather['list']) > 0)
    <h3 class="text-center mb-4">Prévisions pour {{ ucfirst($city) }}</h3>

    <div class="row justify-content-center">
        @foreach($weather['list'] as $f)
            @php
                $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $f['dt_txt'])->locale('fr');
                $icon = $f['weather'][0]['icon'] ?? '01d';
                $temp = round($f['main']['temp']);
                $desc = ucfirst($f['weather'][0]['description'] ?? '');
            @endphp

            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card shadow-sm text-center p-3">
                    <!-- 📅 Date formatée en français -->
                    <p class="fw-bold mb-1">
                        {{ $date->isoFormat('ddd D MMM à HH[h]') }}
                    </p>

                    <!-- 🌤️ Icône météo -->
                    <img src="https://openweathermap.org/img/wn/{{ $icon }}@2x.png" 
                         alt="Météo" width="60" height="60">

                    <!-- 🌡️ Température -->
                    <h5 class="mt-2">{{ $temp }}°C</h5>

                    <!-- 🌈 Description -->
                    <p class="text-muted mb-0">{{ $desc }}</p>
                </div>
            </div>
        @endforeach
    </div>
@endif



    <!-- Carte -->
    <div class="mt-5">
        <h3 class="text-center mb-3">Localisation : {{ ucfirst($city) }}</h3>
        <div id="map"></div>
    </div>

    {{-- @if($tidesRegion && $tidesCommune) --}}
    {{-- <div class="text-center mt-4"> --}}
        {{-- <a href="{{ route('tides.show', ['region' => $tidesRegion, 'commune' => $tidesCommune]) }}" --}}
           {{-- class="btn btn-info">🌊 Voir les marées pour {{ ucfirst($city) }}</a> --}}
    {{-- </div> --}}
    {{-- @endif --}}
</div>

<!-- Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var lat = {{ $lat ?? 14.6937 }};
    var lon = {{ $lon ?? -17.4441 }};
    var map = L.map('map').setView([lat, lon], 8);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18, attribution: '© OpenStreetMap'
    }).addTo(map);
    L.marker([lat, lon]).addTo(map)
        .bindPopup("<b>{{ ucfirst($city ?? 'Dakar') }}</b><br>Latitude: " + lat + "<br>Longitude: " + lon)
        .openPopup();
});

// Changer d’onglet météo
function showTab(tab) {
    const params = new URLSearchParams(window.location.search);
    params.set('type', tab);
    window.location.search = params.toString();
}
</script>
@endsection
