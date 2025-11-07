@extends('layouts.app')

@section('title', 'Historique des Localisations')

@section('content')
<div class="container mt-4">
    <h3 class="text-center mb-4">🌍 Historique de mes localisations</h3>

    <!-- Bouton pour se localiser -->
    <div class="text-center mb-3">
        <a href="{{ route('gps.locate') }}" class="btn btn-success" id="locateNow">📍 Me localiser maintenant</a>
    </div>

    <!-- Carte -->
    <div id="map" style="height: 500px; border-radius: 10px; border: 1px solid #ccc;"></div>

    <!-- Table -->
    <div class="mt-4">
        <h5>📋 Liste des localisations enregistrées</h5>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>Adresse IP</th>
                    <th>Pays</th>
                    <th>Ville</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gpsData as $gps)
                    <tr>
                        <td>{{ $gps->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $gps->ip }}</td>
                        <td>{{ $gps->country }}</td>
                        <td>{{ $gps->city }}</td>
                        <td>{{ $gps->latitude }}</td>
                        <td>{{ $gps->longitude }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Leaflet.js -->
<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-sA+Bxv9rQ7RkLz1O+g7GPuCv6zDdQ3XzYh7g6hE0XnY="
    crossorigin=""
/>
<script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-o9N1johkB8f2FzJ8U1U2jqTlgO3Yp1cEMG96ohp3pEw="
    crossorigin=""
></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const gpsData = @json($gpsData);
    const map = L.map('map').setView([14.4974, -14.4524], 6);

    // Fond de carte OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Ajouter les marqueurs
    gpsData.forEach(loc => {
        const marker = L.marker([loc.latitude, loc.longitude]).addTo(map);
        marker.bindPopup(`<b>${loc.city}</b><br>${loc.country}<br>IP: ${loc.ip}<br>${loc.created_at}`);
    });

    if (gpsData.length > 0) {
        const last = gpsData[0];
        map.setView([last.latitude, last.longitude], 10);
    }

    // Lien pour actualiser localisation sans recharger toute la page
    document.getElementById('locateNow').addEventListener('click', function(e) {
        e.preventDefault();
        fetch("{{ route('gps.locate') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'ok') location.reload();
            else alert('Erreur : ' + data.message);
        })
        .catch(() => alert('Erreur de connexion'));
    });
});
</script>
@endsection
