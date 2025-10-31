@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Partage de ma position</h1>
    <p id="status">Clique sur le bouton pour partager ta position.</p>
    <button id="getLocationBtn" class="btn btn-primary">Partager ma position</button>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('getLocationBtn').addEventListener('click', () => {
    const status = document.getElementById('status');

    if (!navigator.geolocation) {
        status.innerText = "Géolocalisation non supportée.";
        fallbackByIp();
        return;
    }

    status.innerText = "Obtention de la position…";

    navigator.geolocation.getCurrentPosition(
        pos => {
            const { latitude, longitude } = pos.coords;
            status.innerText = `Lat: ${latitude.toFixed(6)}, Lon: ${longitude.toFixed(6)} — Envoi...`;
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
    .then(r => r.json())
    .then(data => {
        status.innerText = data.status === 'recorded'
            ? "Position enregistrée !"
            : "Erreur backend.";
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
    .then(r => r.json())
    .then(data => {
        if (data.status === 'recorded') {
            status.innerText = `Position approximative (IP) : lat=${data.position.latitude}, lon=${data.position.longitude}`;
        } else {
            status.innerText = "Localisation via IP échouée.";
        }
    })
    .catch(err => {
        console.error(err);
        status.innerText = "Erreur réseau IP.";
    });
}
</script>
@endpush
