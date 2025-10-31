@extends('layouts.app')

@section('title', 'Carte des marées')

@section('content')
    <div id="map" style="height: 600px;"></div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            // Créer la carte
            const map = L.map('map').setView([14.67, -17.42], 6); // Sénégal

            // Ajouter fond de carte
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Appel API Laravel
            const response = await fetch('/api/tides/externe');
            const data = await response.json();

            // Coords des villes (doivent être les mêmes que dans le contrôleur)
            const coords = {
                "Dakar": [14.67, -17.42],
                "Ziguinchor": [12.58, -16.28],
                "Kaolack": [13.95, -16.45],
                "Saint-Louis": [16.02, -16.48],
            };

            // Ajouter un marker pour chaque ville
            for (const [ville, extremes] of Object.entries(data)) {
                const [lat, lon] = coords[ville];

                const contenu = extremes.length > 0
                    ? extremes.map(e => `${e.date} - ${e.type} - ${e.height} m`).join('<br>')
                    : 'Aucune donnée disponible';

                L.marker([lat, lon]).addTo(map)
                    .bindPopup(`<b>${ville}</b><br>${contenu}`);
            }
        });
    </script>
@endpush
