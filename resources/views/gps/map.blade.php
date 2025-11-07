@extends('layouts.app')

@section('title', 'Ma position')

@section('content')
<div class="container mt-4">
    <h3 class="text-center mb-3">📍 Ma position</h3>

    <!-- Bouton me localiser -->
    <div class="text-center mb-3">
        <button id="locateBtn" class="btn btn-primary">Me localiser</button>
    </div>

    <!-- Bloc infos -->
    <div id="info" class="card p-3 mb-3" style="display:none;">
        <p><b>IP :</b> <span id="ip"></span></p>
        <p><b>Pays :</b> <span id="country"></span></p>
        <p><b>Ville :</b> <span id="city"></span></p>
        <p><b>Latitude :</b> <span id="lat"></span></p>
        <p><b>Longitude :</b> <span id="lon"></span></p>
    </div>

    <!-- Carte Leaflet -->
    <div id="map" style="height:500px; border-radius:8px; border:1px solid #ddd;"></div>
</div>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
document.addEventListener('DOMContentLoaded', () => {
    const info = document.getElementById('info');
    const map = L.map('map').setView([14.7167, -17.4677], 6); // Sénégal par défaut
    let marker = null;

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const showPosition = (lat, lon, city = '', country = '', ip = '') => {
        info.style.display = 'block';
        document.getElementById('ip').textContent = ip;
        document.getElementById('country').textContent = country;
        document.getElementById('city').textContent = city;
        document.getElementById('lat').textContent = lat;
        document.getElementById('lon').textContent = lon;

        const latlng = [lat, lon];
        if (marker) map.removeLayer(marker);
        marker = L.marker(latlng).addTo(map)
            .bindPopup((city ? city + ', ' : '') + (country || ''))
            .openPopup();
        map.setView(latlng, 12);
    }

    const locateByIP = () => {
        fetch('{{ route("gps.locate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({})
        })
        .then(r => r.json())
        .then(data => {
            if (!data || data.status !== 'ok') {
                alert('Erreur localisation par IP : ' + (data?.message ?? 'aucune donnée'));
                return;
            }
            showPosition(data.latitude, data.longitude, data.city, data.country, data.ip);
        })
        .catch(err => {
            console.error(err);
            alert('Erreur réseau / serveur : ' + err.message);
        });
    }

    document.getElementById('locateBtn').addEventListener('click', () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                pos => {
                    const lat = pos.coords.latitude;
                    const lon = pos.coords.longitude;
                    showPosition(lat, lon, 'Ma position', '', '');
                },
                err => {
                    console.warn('Géolocalisation échouée :', err.message);
                    alert('Impossible de récupérer votre position via le navigateur, utilisation de la localisation par IP.');
                    locateByIP();
                },
                { enableHighAccuracy: true, timeout: 10000 }
            );
        } else {
            alert('Géolocalisation non supportée, utilisation de la localisation par IP.');
            locateByIP();
        }
    });
});
</script>
@endsection
