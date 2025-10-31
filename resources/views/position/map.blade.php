@extends('layouts.app')

@section('content')
<div class="container">
    <h2>📍 Positions GPS en temps réel</h2>
    <button id="refreshBtn" class="btn btn-primary mb-3">🔄 Actualiser</button>
    <div id="map" style="height: 600px;"></div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
let map = L.map('map').setView([14.7167, -17.4677], 8);
let markers = L.layerGroup().addTo(map);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

function loadPositions() {
    fetch('/api/positions')
        .then(res=>res.json())
        .then(data=>{
            markers.clearLayers();
            data.forEach(pos=>{
                L.marker([pos.latitude,pos.longitude])
                 .bindPopup(`Device: ${pos.device_id}<br>Lat: ${pos.latitude}<br>Lon: ${pos.longitude}<br>Speed: ${pos.speed} km/h`)
                 .addTo(markers);
            });
        });
}

document.getElementById('refreshBtn').addEventListener('click', loadPositions);
loadPositions();
setInterval(loadPositions,15000);
</script>
@endsection
