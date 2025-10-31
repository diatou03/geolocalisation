@extends('layouts.app')

@section('title', 'Météo • ' . ($weather['name'] ?? 'Ville'))
@section('page_header', 'Rechercher la météo')

@push('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/.../font-awesome.min.css">
@endpush

@section('content')
<form method="GET" action="{{ route('weather.show') }}">
  <label for="city">Ville :</label>
  <input type="text" name="city" id="city" value="{{ old('city', $city ?? 'Kaolack') }}">
  <button type="submit">Rechercher</button>
</form>
<style>
  /* Container général */
.weather-container {
  max-width: 400px;
  margin: 2rem auto;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  padding: 1.5rem;
  font-family: 'Arial', sans-serif;
}

.weather-container h2 {
  text-align: center;
  color: #003f7f;
  margin-bottom: 1rem;
}

/* Ligne météo principale */
.weather-main {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.weather-main img {
  width: 80px;
  height: 80px;
}

.weather-info {
  flex: 1;
  margin-left: 1rem;
}

.weather-info p {
  margin: 0.25rem 0;
  font-size: 1.1rem;
}

/* Liste des marées */
.tides-container {
  margin-top: 1.5rem;
}

.tides-container h3 {
  margin-bottom: 0.75rem;
  color: #0056b3;
}

.tides-container ul {
  list-style: none;
  padding: 0;
}

.tides-container li {
  display: flex;
  justify-content: space-between;
  padding: 0.5rem 0;
  border-bottom: 1px solid #e0e0e0;
}

.tides-container li:last-child {
  border-bottom: none;
}

/* Formulaire recherche */
form {
  display: flex;
  justify-content: center;
  margin-bottom: 1rem;
}

form label {
  margin-right: 0.5rem;
  font-weight: bold;
}

form input {
  padding: 0.4rem 0.75rem;
  border: 1px solid #ccc;
  border-radius: 6px;
  margin-right: 0.5rem;
  width: 200px;
}

form button {
  background-color: #0056b3;
  color: #fff;
  border: none;
  padding: 0.4rem 0.9rem;
  border-radius: 6px;
  cursor: pointer;
  transition: background-color 0.2s;
}

form button:hover {
  background-color: #004194;
}

/* Responsive */
@media (max-width: 480px) {
  .weather-main {
    flex-direction: column;
    align-items: center;
  }
  form {
    flex-direction: column;
    align-items: center;
  }
  form input {
    margin-bottom: 0.5rem;
    width: 100%;
  }
}

</style>
@if ($weather)
  <div class="weather-container">
    <h2>Météo à {{ $weather['name'] }}</h2>
    @php $icon = $weather['weather'][0]['icon']; @endphp
    <img src="http://openweathermap.org/img/wn/{{ $icon }}@2x.png" alt="Icône météo" style="width:100px;height:100px;">
    <p>🌡️ Température : {{ $weather['main']['temp'] }} °C</p>
    <p>💧 Humidité : {{ $weather['main']['humidity'] }} %</p>
    <p><i class="fa-solid fa-wind"></i> 🌬️Vent : {{ $weather['wind']['speed'] }} km/h</p>
    <p>☁️ Description : {{ ucfirst($weather['weather'][0]['description']) }}</p>
    @if (!empty($tides))
  <div class="tides-container">
    <h3>Marées</h3>
    <ul>
      @foreach ($tides as $tide)
        <li>
          {{ \Carbon\Carbon::createFromTimestamp($tide['date']) // timestamp en millisecondes ?
             ->format('d/m H:i') }}
          — {{ $tide['type'] === 'h' ? 'Haute' : 'Basse' }}
          ({{ number_format($tide['height'], 2) }} m)
        </li>
      @endforeach
    </ul>
  </div>
@endif

  </div>
@elseif ($error)
  <div class="alert alert-danger">{{ $error }}</div>
@else
  <div class="alert alert-info">Veuillez entrer une ville pour voir la météo.</div>
  
@endif
@endsection
