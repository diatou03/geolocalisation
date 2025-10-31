{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('title', 'Accueil GPS')

@section('content')
<div class="container mt-4">
    <h1>Bienvenue au suivi GPS</h1>

    <div class="row my-4">
        <div class="col-md-6">
            <h2>Partager ma position</h2>
            <p id="status">Cliquez sur le bouton pour partager votre position.</p>
            <button id="getLocationBtn" class="btn btn-primary">Partager ma position</button>
        </div>
        <div class="col-md-6">
            <h2>Aperçu des dernières positions</h2>
            @if(isset($latest) && $latest->isNotEmpty())
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Date / Heure</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latest as $item)
                            <tr>
                                <td>{{ $item['id'] }}</td>
                                <td>{{ $item['nom'] }}</td>
                                <td>{{ $item['latitude'] ?? '—' }}</td>
                                <td>{{ $item['longitude'] ?? '—' }}</td>
                                <td>
                                    @if($item['captured_at'])
                                        {{ \Carbon\Carbon::parse($item['captured_at'])->format('d/m/Y H:i:s') }}
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <a href="{{ route('gps.map') }}" class="btn btn-secondary mt-2">Voir la carte complète</a>
            @else
                <p>Aucune position disponible pour le moment.</p>
                <a href="{{ route('gps.map') }}" class="btn btn-secondary mt-2">Voir la carte</a>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('getLocationBtn').addEventListener('click', () => {
    const status = document.getElementById('status');

    if (!navigator.geolocation) {
        status.innerText = "Géolocalisation non supportée par ce navigateur.";
        fallbackByIp();
        return;
    }

    status.innerText = "Obtention de la position…";

    navigator.geolocation.getCurrentPosition(
        pos => {
            const { latitude, longitude } = pos.coords;
            status.innerText = `Lat: ${latitude.toFixed(6)}, Lon: ${longitude.toFixed(6)} — Envoi…`;
            sendPosition(latitude, longitude);
        },
        error => {
            status.innerText = "Erreur géolocalisation : ";
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    status.innerText += "Permission refusée.";
                    break;
                case error.POSITION_UNAVAILABLE:
                    status.innerText += "Position indisponible.";
                    break;
                case error.TIMEOUT:
                    status.innerText += "Délai dépassé.";
                    break;
                default:
                    status.innerText += "Erreur inconnue.";
            }
            fallbackByIp();
        },
        { enableHighAccuracy: true, timeout: 10000 }
    );
});

function sendPosition(lat, lon) {
    const status = document.getElementById('status');
    fetch("{{ route('gps.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ latitude: lat, longitude: lon })
    })
    .then(resp => resp.json())
    .then(data => {
        if (data.status === 'recorded') {
            status.innerText = "Position enregistrée !";
        } else {
            status.innerText = "Erreur backend : " + (data.message ?? "");
        }
    })
    .catch(err => {
        console.error(err);
        status.innerText = "Erreur réseau.";
    });
}

function fallbackByIp() {
    const status = document.getElementById('status');
    status.innerText += " Tentative par IP…";

    fetch("{{ route('gps.storeByIp') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({})
    })
    .then(resp => resp.json())
    .then(data => {
        if (data.status === 'recorded') {
            status.innerText = `Position approximative (IP) : lat=${data.position.latitude}, lon=${data.position.longitude}`;
        } else {
            status.innerText = "Localisation via IP impossible.";
        }
    })
    .catch(err => {
        console.error(err);
        status.innerText = "Erreur réseau IP.";
    });
}
</script>
@endpush
