@extends('layouts.app')

@section('content')
    <div id="map" style="width:100%; height:600px;">
        <p id="map-message" style="text-align:center; padding-top:280px;">Chargement de la carte...</p>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const positions = @json($positions);
            console.log("Positions reçues :", positions);

            const valid = positions.some(p => p.latitude != null && p.longitude != null);
            if (!valid) {
                document.getElementById('map').innerHTML = '<p style="text-align:center; padding-top:280px;">Aucune position disponible.</p>';
                return;
            }

            const map = L.map('map').setView([0, 0], 2);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributeurs',
                maxZoom: 18
            }).addTo(map);

            const group = L.featureGroup();
            positions.forEach((pos, index) => {
                if (pos.latitude != null && pos.longitude != null && pos.pirogue) {
                    console.log(`Marqueur ${index}: ${pos.pirogue.nom}`);
                    L.marker([pos.latitude, pos.longitude])
                        .bindPopup(`<strong>${pos.pirogue.nom}</strong><br>Lat: ${pos.latitude}<br>Lng: ${pos.longitude}`)
                        .addTo(group);
                } else {
                    console.log(`Données manquantes pour l’index ${index}`, pos);
                }
            });

            group.addTo(map);
            map.fitBounds(group.getBounds(), { padding: [20, 20] });
            setTimeout(() => map.invalidateSize(), 200);
        });
    </script>
@endpush
