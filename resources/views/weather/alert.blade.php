@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Alerte Météo – {{ $city }}</h1>

    <form method="GET" action="{{ route('weather.alert') }}" class="mb-4 d-flex">
        <input type="text" name="city" class="form-control me-2" placeholder="Entrez une ville (ex. Dakar)" value="{{ old('city', $city) }}">
        <button class="btn btn-primary">Vérifier</button>
    </form>
<a href="{{ route('send-weather-alerts') }}"
   onclick="event.preventDefault(); document.getElementById('weather-alert-form').submit();"></a>
<form id="weather-alert-form" action="{{ route('send-weather-alerts') }}" method="POST" style="display: none;">
    @csrf
</form>

    @isset($error)
        <div class="alert alert-danger">{{ $error }}</div>
    @endisset

    @isset($alert)
        <div class="alert alert-warning">
            <strong>⚠ Alerte :</strong> {{ $alert }}
            
        </div>
    @endisset

    @isset($data)
        <div class="mt-4">
            <h3>Météo actuelle</h3>
            <ul class="list-group">
                <li class="list-group-item">Température : {{ $data['main']['temp'] }} °C</li>
                <li class="list-group-item">Vent : {{ $data['wind']['speed'] }} m/s</li>
                <li class="list-group-item">Condition : {{ ucfirst($data['weather'][0]['description']) }}</li>
                <li class="list-group-item">Pluie (1h) : {{ $data['rain']['1h'] ?? 0 }} mm</li>
            </ul>
        </div>
        Notification.requestPermission().then(permission => {
  if (permission === 'granted') {
    // subscribe via PushManager, envoyer l’objet à backend
  }
});

    @endisset
</div>
@endsection
