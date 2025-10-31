@extends('layouts.app')

@section('title', 'Météo • ' . ucfirst($city ?? 'Ville'))
@section('page_header', 'Météo')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f0f4f8;
    margin: 0;
    padding: 0;
}

.search-form-container {
    display: flex;
    justify-content: center;
    margin-top: 30px;
}

.search-form {
    display: flex;
    align-items: center;
    background: white;
    border-radius: 50px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    padding: 10px 20px;
    gap: 10px;
    flex-wrap: wrap;
}

.search-form input {
    border: none;
    outline: none;
    padding: 10px 15px;
    font-size: 16px;
    border-radius: 50px;
    width: 250px;
    text-align: center;
}

.search-form button {
    border: none;
    outline: none;
    padding: 5px 10px;
    border-radius: 50px;
    background-color: #0056b3;
    color: white;
    font-size: 16px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: background-color 0.3s;
}

.search-form button:hover { background-color: #003f7f; }

.weather-container {
    max-width: 950px;
    margin: 50px auto;
    background: white;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 6px 16px rgba(0,0,0,0.15);
}

.weather-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 10px;
    margin-top: 20px;
    text-align: center;
}

.weather-box {
    background-color: #f8faff;
    border: 1px solid #d3e0ff;
    border-radius: 10px;
    padding: 15px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
}

.weather-box .icon {
    font-size: 60px;
    color: #0056b3;
    margin-bottom: 10px;
}

.weather-box h4 { margin: 10px 0 5px; font-size: 18px; color: #333; }
.weather-box p { font-size: 16px; color: #555; }

.weather-date { font-size: 20px; margin-bottom: 20px; }

/* Fonds météo */
.weather-clear { background-color: #ffeaa7; }
.weather-clouds { background-color: #dfe6e9; }
.weather-rain { background-color: #a9c9ff; }
.weather-thunderstorm { background-color: #9fa8da; }
.weather-snow { background-color: #ecf0f1; }
.weather-mist, .weather-fog { background-color: #b2bec3; }
.weather-default { background-color: #f0f4f8; }

@media (max-width:480px){
    .weather-box { padding: 15px; }
    .search-form input { width: 180px; }
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

<div class="weather-container">

    {{-- 🔍 Formulaire de recherche --}}
    <div class="search-form-container">
        <form class="search-form" method="GET" action="{{ route('weather.index') }}">
            <input type="text" name="city" value="{{ $city }}" placeholder="Entrez une ville">
            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i> Rechercher</button>
        </form>
    </div>

    @if(!empty($error))
        <p style="color:red;margin-top:15px;">{{ $error }}</p>
    @endif

    {{-- 🌤️ Météo actuelle --}}
    @if ($type === 'current' && !empty($weather['weather'][0]))
        @php
            $icon = $weather['weather'][0]['icon'] ?? '01d';
            $desc = ucfirst($weather['weather'][0]['description'] ?? '');
            $weatherClass = getWeatherClass($icon);
        @endphp
        <div class="weather-date">Date : {{ $currentDate }}</div>
        <h2>Météo actuelle à {{ ucfirst($city) }}</h2>
        <img src="https://openweathermap.org/img/wn/{{ $icon }}@2x.png" alt="Météo">
        <p><strong>Description :</strong> {{ $desc }}</p>

        <div class="weather-info-grid">
            <div class="weather-box weather-clear">
                <i class="fa-solid fa-temperature-half icon"></i>
                <h4>Température</h4>
                <p>{{ $weather['main']['temp'] ?? '?' }} °C</p>
            </div>
            <div class="weather-box weather-clear">
                <i class="fa-solid fa-droplet icon"></i>
                <h4>Humidité</h4>
                <p>{{ $weather['main']['humidity'] ?? '?' }} %</p>
            </div>
            <div class="weather-box weather-clear">
                <i class="fa-solid fa-wind icon"></i>
                <h4>Vent</h4>
                <p>{{ $weather['wind']['speed'] ?? '?' }} km/h</p>
            </div>
            <div class="weather-box weather-clear">
                <i class="fa-solid fa-gauge-high icon"></i>
                <h4>Pression</h4>
                <p>{{ $weather['main']['pressure'] ?? '?' }} hPa</p>
            </div>
        </div>
    @endif
@endsection
