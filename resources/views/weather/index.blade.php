@extends('layouts.app')

@section('title', 'Météo • ' . ucfirst($city ?? 'Ville'))
@section('page_header', 'Météo')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
/* ... (conserver tout le CSS existant) ... */
<style> body { font-family: Arial, sans-serif; background-color: #f0f4f8; margin: 0; padding: 0; } 
/* 🌍 En-tête avec ville et boutons */ 
.top-header { display: flex; flex-direction: column; align-items: center; gap: 15px; margin-top: 25px; } 
.city-title { 
font-size: 28px; 
font-weight: bold; color: #333; }
.weather-buttons { display: flex; gap: 10px; } 
.weather-buttons a, 
.weather-buttons button { text-decoration: none; padding: 10px 20px; border-radius: 25px; color: white; border: none; cursor: pointer; transition: 0.3s; font-size: 15px; } 
.weather-buttons a { background-color: #0056b3; } 
.weather-buttons a:hover { background-color: #003f7f; } 
.weather-buttons button { background-color: #999; } 
.weather-buttons button:hover { background-color: #666; } 
/* 🔍 Barre de recherche */ 
.search-form-container { 
display: flex; justify-content: center; 
 margin-top: 15px; } 
.search-form { 
display: flex; align-items: center; background: white; border-radius: 50px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); padding: 10px 20px; gap: 10px; flex-wrap: wrap; width: 500px; }
.search-form input { border: none; outline: none; padding: 10px 15px; font-size: 16px; border-radius: 50px; width: 300px; text-align: center; } .search-form button { border: none; outline: none; padding: 5px 10px; border-radius: 50px; background-color: #0056b3; color: white; font-size: 16px; cursor: pointer; display: flex; align-items: center; gap: 5px; transition: background-color 0.3s; } .search-form button:hover { background-color: #003f7f; } 
 /* 🌦️ Conteneur principal */ 
.weather-container { 
max-width: 1500px; margin: 10px auto; background: white; padding: 10px; border-radius: 20px; text-align: center; box-shadow: 0 6px 16px rgba(0,0,0,0.15); } 
/* 🧱 Grille météo */ 
 .weather-info-grid { 
display: grid; grid-template-columns: repeat(auto-fit, minmax(290px, 1fr)); gap: 20px; margin-top: 10px; text-align: center; }
/* 🧊 Cartes météo */ 
 .weather-box { background-color: #f8faff; 
border: 1px solid #d3e0ff; 
border-radius: 15px; padding: 20px; 
box-shadow: 0 3px 8px rgba(0,0,0,0.1);
transition: transform 0.2s ease, box-shadow 0.2s ease; } 
.weather-box:hover { 
transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); } .weather-box .icon { font-size: 60px; color: #0056b3; margin-bottom: 10px; } .weather-box h4 { margin: 10px 0 5px; font-size: 18px; color: #333; } .weather-box p { font-size: 16px; color: #555; } .weather-date { font-size: 20px; margin-bottom: 10px; } 
/* 🎨 Couleurs météo */ 
 .weather-clear { background-color: #ffeaa7;}
.weather-clouds { background-color: #dfe6e9; }
.weather-rain { background-color: #a9c9ff; }
.weather-thunderstorm { background-color: #9fa8da; }
.weather-snow { background-color: #ecf0f1; }
.weather-mist, .weather-fog { background-color: #b2bec3; }
.weather-default { background-color: #f0f4f8; }
/* 📱 Responsive */
@media (max-width:480px){
.weather-box { padding: 15px; }
.search-form input { width: 180px; } } 
/* Onglets météo */
.weather-tabs {
    display: flex;
    justify-content: center;
    margin-top: 25px;
    gap: 10px;
}

.weather-tab {
    padding: 10px 20px;
    border-radius: 25px;
    cursor: pointer;
    font-weight: 600;
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

/* Formulaire météo passée */
#historicalForm {
    margin-top: 20px;
    display: none;
    text-align: center;
}

#historicalForm input,
#historicalForm button {
    margin: 5px;
    padding: 8px 12px;
    border-radius: 25px;
    border: 1px solid #ccc;
}

#historicalForm button {
    background-color: #0056b3;
    color: white;
    border: none;
    cursor: pointer;
}

#historicalForm button:hover {
    background-color: #003f7f;
}
</style>

@section('content')

@php
    $type = $type ?? 'current';
    $city = $city ?? 'Ville';
    $currentDate = \Carbon\Carbon::now()->format('d/m/Y');

    function getWeatherClass($icon) {
        $code = substr($icon,0,2);
        switch($code) {
            case '01': return 'weather-clear';
            case '02':
            case '03':
            case '04': return 'weather-clouds';
            case '09':
            case '10': return 'weather-rain';
            case '11': return 'weather-thunderstorm';
            case '13': return 'weather-snow';
            case '50': return 'weather-mist';
            default: return 'weather-default';
        }
    }
@endphp

<div class="flex flex-col items-center mt-6">
    {{-- Onglets météo --}}
    <div class="weather-tabs">
        <div class="weather-tab {{ $type === 'current' ? 'active' : 'inactive' }}" onclick="showTab('current')">🌤️ Météo actuelle</div>
        <div class="weather-tab {{ $type === 'forecast' ? 'active' : 'inactive' }}" onclick="showTab('forecast')">📅 Prévisions 3 jours</div>
        <div class="weather-tab {{ $type === 'historical' ? 'active' : 'inactive' }}" onclick="showTab('historical')">🕓 Météo passée</div>
    </div>

    {{-- Barre de recherche --}}
    <div class="search-form-container">
        <form class="search-form" method="GET" action="{{ route('weather.show') }}">
            <input type="text" name="city" value="{{ $city }}" placeholder="Entrez une ville">
            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i> Rechercher</button>
        </form>
    </div>
</div>

{{-- Message d'erreur --}}
@if(!empty($error))
    <p style="color:red;margin-top:15px;text-align:center;">{{ $error }}</p>
@endif

{{-- 🌤️ Contenu météo --}}
<div class="weather-container">

   {{-- Météo actuelle --}}
@if($type === 'current' && !empty($weather['weather'][0]))
    @php
        $icon = $weather['weather'][0]['icon'] ?? '01d';
        $desc = ucfirst($weather['weather'][0]['description'] ?? '');
        $weatherClass = getWeatherClass($icon);
        $currentTime = \Carbon\Carbon::now()->setTimezone($weather['timezone'] ?? 'UTC')->format('H:i'); // Heure locale
    @endphp

    <h2 class="city-title">Météo à {{ ucfirst($city) }}</h2>
    <div class="weather-date">Date : {{ $currentDate }}</div>
    <div class="weather-time">Heure : {{ $currentTime }}</div>

    <p><strong>Description :</strong> {{ $desc }}</p>
    <img src="https://openweathermap.org/img/wn/{{ $icon }}@2x.png" alt="Météo">

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
    @if($type === 'forecast' && !empty($weather['list']))
        <h2 class="city-title">Prévisions sur 3 jours pour {{ ucfirst($city) }}</h2>
        <div class="weather-info-grid">
            @foreach ($weather['list'] as $item)
                @php
                    $icon = $item['weather'][0]['icon'] ?? '01d';
                    $desc = ucfirst($item['weather'][0]['description'] ?? '');
                    $weatherClass = getWeatherClass($icon);
                    $date = \Carbon\Carbon::parse($item['dt_txt'])->format('d/m H:i');
                @endphp
                <div class="weather-box {{ $weatherClass }}">
                    <img src="https://openweathermap.org/img/wn/{{ $icon }}@2x.png" alt="">
                    <h4>{{ $date }}</h4>
                    <p><strong>Description :</strong> {{ $desc }}</p>
                    <p><strong>{{ $item['main']['temp'] ?? '?' }} °C</strong></p>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Météo passée --}}
    @if($type === 'historical')
        <h2 class="city-title">Météo passée pour {{ ucfirst($city) }}</h2>
        <form id="historicalForm" action="{{ route('weather.show') }}" method="GET">
            <input type="hidden" name="city" value="{{ $city }}">
            <input type="hidden" name="type" value="historical">
            <label>Choisissez une date :</label>
            <input type="date" name="date" max="{{ date('Y-m-d') }}" required>
            <button type="submit">Voir</button>
        </form>

        @if(!empty($weather['weather'][0]))
            @php
                $icon = $weather['weather'][0]['icon'] ?? '01d';
                $desc = ucfirst($weather['weather'][0]['description'] ?? '');
                $weatherClass = getWeatherClass($icon);
                $date = \Carbon\Carbon::parse($weather['current']['dt'])->format('d/m/Y');
            @endphp
            <div class="weather-info-grid mt-4">
                <div class="weather-box {{ $weatherClass }}">
                    <img src="https://openweathermap.org/img/wn/{{ $icon }}@2x.png" alt="">
                    <h4>{{ $date }}</h4>
                    <p><strong>Description :</strong> {{ $desc }}</p>
                    <p><strong>{{ $weather['current']['temp'] ?? '?' }} °C</strong></p>
                </div>
            </div>
        @endif
    @endif
</div>

<script>
function showTab(tab) {
    const params = new URLSearchParams(window.location.search);
    params.set('type', tab);
    window.location.search = params.toString();
}
</script>

@endsection
