@extends('layouts.app')

@section('title', 'Carte des positions GPS')

@section('content')
<div class="container-fluid mt-4">
    <h1 class="text-center text-primary mb-4">
        <i class="fa-solid fa-map-location-dot"></i> Carte en temps réel des positions GPS
    </h1>

    <div id="map" style="height: 600px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.2);"></div>
</div>

{{-- CDN Leaflet --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Création de la carte centrée sur le Sénégal
    var map = L.map('map').setView([14.6937, -17.4441], 7); // Dakar par défaut

    // Couche de fond (OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    // Fonction pour charger les positions depuis Laravel
    async function loadPositions() {
        const response = await fetch('/api/positions');
        const data = await response.json();

        // Supprimer les anciens marqueurs si nécessaire
        if (window.markers) {
            window.markers.forEach(m => map.removeLayer(m));
        }
        window.markers = [];

        data.forEach(pos => {
            if (pos.latitude && pos.longitude) {
                const marker = L.marker([pos.latitude, pos.longitude]).addTo(map);
                marker.bindPopup(`
                    <b>Appareil:</b> ${pos.device_id}<br>
                    <b>Latitude:</b> ${pos.latitude.toFixed(6)}<br>
                    <b>Longitude:</b> ${pos.longitude.toFixed(6)}<br>
                    <b>Altitude:</b> ${pos.altitude ?? '-'} m<br>
                    <b>Vitesse:</b> ${pos.speed ?? '-'} km/h<br>
                    <b>Satellites:</b> ${pos.satellites ?? '-'}<br>
                    <b>Heure:</b> ${pos.timestamp ?? '—'}
                `);
                window.markers.push(marker);
            }
        });
    }

    // Chargement initial
    loadPositions();

    // Rafraîchir toutes les 10 secondes
    setInterval(loadPositions, 10000);
});
</script>
@endsection
