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

/* En-tête accueil */
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

/* Formulaire météo */
.search-form-home {
    display: flex;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}
.search-form-home input {
    padding: 9px 15px;
    border-radius: 50px;
    border: 1px solid #ccc;
    width: 600px;
}
.search-form-home button {
    padding: 17px 30px;
    border-radius: 50px;
    border: none;
    background-color: #0056b3;
    color: white;
    cursor: pointer;
    transition: 0.3s;
}
.search-form-home button:hover {
    background-color: #003f7f;
}

/* Boutons marées */
.btn-tides {
    background-color: #17a2b8;
    color: white;
    padding: 15px 25px;
    border-radius: 45px;
    text-decoration: none;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: 0.3s;
}
.btn-tides:hover {
    background-color: #138496;
}

/* Onglets météo */
.weather-tabs {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin: 30px 0 15px 0;
}
.weather-tab {
    padding: 10px 20px;
    border-radius: 25px;
    cursor: pointer;
    font-weight: 800;
    transition: background 0.3s, color 0.3s;
}
.weather-tab.active {
    background-color: #0056b3;
    color: white;
}
.weather-tab.inactive {
    background-color: #f0f0f0;
    color: #333;
}

/* Conteneurs météo */
.weather-container-home {
    max-width: 900px;
    margin: 0 auto 50px auto;
    background: white;
    padding: 20px;
    border-radius: 20px;
    box-shadow: 0 6px 16px rgba(0,0,0,0.1);
}

/* Grille météo */
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
.weather-box h4 {
    margin: 10px 0 5px;
    font-size: 16px;
    color: #333;
}
.weather-box p {
    font-size: 14px;
    color: #555;
}

/* Carte */
#map {
    border-radius: 0.5rem;
    height: 400px;
    width: 100%;
}

/* Responsive */
@media (max-width:480px){
    .search-form-home input { width: 180px; }
    .btn-tides { width: 100%; justify-content: center; }
}
</style>
@endsection

@section('content')
<div class="header-home">
    {{-- <h1>🌊 Nap Ak Karangue</h1> --}}
    {{-- <p>Bienvenue sur la plateforme de sécurité en mer.<br> --}}
       {{-- Consultez la <strong>météo</strong> et les <strong>marées</strong> selon votre commune.</p> --}}

    {{-- Formulaire météo --}}
    <form class="search-form-home" method="GET" action="{{ route('weather.show') }}">
        <input type="text" name="city" placeholder="Entrez une ville" value="{{ $city ?? 'Dakar' }}">
        <button type="submit"><i class="fa-solid fa-cloud-sun me-1"></i> Voir la météo</button>
        {{-- Bouton vers page marées --}}
        <div class="d-flex justify-content-center gap-3 flex-wrap mt-4">
        <a href="{{ route('tides.index') }}" class="btn-tides">
            <i class="fa-solid fa-water"></i> Marées par commune
         </a>
         </div>
    </form>

    
</div>

{{-- Onglets météo --}}
<div class="weather-tabs">
    {{-- <div class="weather-tab {{ ($type ?? 'current') === 'current' ? 'active' : 'inactive' }}" onclick="showTab('current')">🌤️ Météo actuelle</div> --}}
    {{-- <div class="weather-tab {{ ($type ?? '') === 'forecast' ? 'active' : 'inactive' }}" onclick="showTab('forecast')">📅 Prévisions 3 jours</div> --}}
    {{-- <div class="weather-tab {{ ($type ?? '') === 'historical' ? 'active' : 'inactive' }}" onclick="showTab('historical')">🕓 Météo passée</div> --}}
</div>

{{-- Conteneur météo --}}
<div class="weather-container-home">
    @php
        function getWeatherClass($icon) {
            $code = substr($icon,0,2);
            switch($code){
                case '01': return 'weather-clear';
                case '02': case '03': case '04': return 'weather-clouds';
                case '09': case '10': return 'weather-rain';
                case '11': return 'weather-thunderstorm';
                case '13': return 'weather-snow';
                case '50': return 'weather-mist';
                default: return 'weather-default';
            }
        }
    @endphp

    {{-- Météo actuelle --}}
    @if(($type ?? 'current') === 'current' && !empty($weather['weather'][0]))
        @php
            $icon = $weather['weather'][0]['icon'] ?? '01d';
            $desc = ucfirst($weather['weather'][0]['description'] ?? '');
            $weatherClass = getWeatherClass($icon);
        @endphp
        <h3 class="text-center">Météo actuelle à {{ ucfirst($city ?? 'Dakar') }}</h3>
        <div class="weather-info-grid">
            <div class="weather-box {{ $weatherClass }}">
                <i class="fa-solid fa-temperature-half icon"></i>
                <h4>Température</h4>
                <p>{{ $weather['main']['temp'] ?? '?' }} °C</p>
            </div>
            <div class="weather-box {{ $weatherClass }}">
                <i class="fa-solid fa-droplet icon"></i>
                <h4>Humidité</h4>
                <p>{{ $weather['main']['humidity'] ?? '?' }} %</p>
            </div>
            <div class="weather-box {{ $weatherClass }}">
                <i class="fa-solid fa-wind icon"></i>
                <h4>Vent</h4>
                <p>{{ $weather['wind']['speed'] ?? '?' }} km/h</p>
            </div>
            <div class="weather-box {{ $weatherClass }}">
                <i class="fa-solid fa-gauge-high icon"></i>
                <h4>Pression</h4>
                <p>{{ $weather['main']['pressure'] ?? '?' }} hPa</p>
            </div>
        </div>
    @endif

    {{-- Prévisions 3 jours --}}
    @if(($type ?? '') === 'forecast' && !empty($weather['list']))
        <h3 class="text-center">Prévisions sur 3 jours pour {{ ucfirst($city ?? 'Dakar') }}</h3>
        <div class="weather-info-grid">
            @foreach($weather['list'] as $item)
                @php
                    $icon = $item['weather'][0]['icon'] ?? '01d';
                    $desc = ucfirst($item['weather'][0]['description'] ?? '');
                    $weatherClass = getWeatherClass($icon);
                    $date = \Carbon\Carbon::parse($item['dt_txt'])->format('d/m H:i');
                @endphp
                <div class="weather-box {{ $weatherClass }}">
                    <img src="https://openweathermap.org/img/wn/{{ $icon }}@2x.png" alt="">
                    <h4>{{ $date }}</h4>
                    <p><strong>{{ $desc }}</strong></p>
                    <p>{{ $item['main']['temp'] ?? '?' }} °C</p>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Météo passée --}}
    @if(($type ?? '') === 'historical' && !empty($weather['weather'][0]))
        <h3 class="text-center">Météo passée pour {{ ucfirst($city ?? 'Dakar') }}</h3>
        <form id="historicalForm" action="{{ route('weather.show') }}" method="GET" class="text-center">
            <input type="hidden" name="city" value="{{ $city }}">
            <input type="hidden" name="type" value="historical">
            <label>Choisissez une date :</label>
            <input type="date" name="date" max="{{ date('Y-m-d') }}" required>
            <button type="submit">Voir</button>
        </form>
        <div class="weather-info-grid mt-4">
            @php
                $icon = $weather['weather'][0]['icon'] ?? '01d';
                $desc = ucfirst($weather['weather'][0]['description'] ?? '');
                $weatherClass = getWeatherClass($icon);
            @endphp
            <div class="weather-box {{ $weatherClass }}">
                <img src="https://openweathermap.org/img/wn/{{ $icon }}@2x.png" alt="">
                <h4>{{ \Carbon\Carbon::parse($weather['current']['dt'])->format('d/m/Y') }}</h4>
                <p><strong>{{ $desc }}</strong></p>
                <p>{{ $weather['current']['temp'] ?? '?' }} °C</p>
            </div>
        </div>
    @endif
</div>

{{-- Carte --}}
<div class="my-5">
    <h3 class="text-center mb-4">Carte sommaire des alertes et positions</h3>
    <div id="map"></div>
</div>
@endsection

@section('scripts')
<script>
function showTab(tab) {
    const params = new URLSearchParams(window.location.search);
    params.set('type', tab);
    window.location.search = params.toString();
}

var map = L.map('map').setView([{{ $lat ?? 14.6928 }}, {{ $lon ?? -17.4467 }}], 8);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

L.marker([{{ $lat ?? 14.6928 }}, {{ $lon ?? -17.4467 }}]).addTo(map)
    .bindPopup('{{ ucfirst($city ?? "Dakar") }}')
    .openPopup();
</script>
@endsection
