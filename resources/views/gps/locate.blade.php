{{-- resources/views/locate.blade.php --}}
@extends('layouts.app')

@section('title', 'Localisation par IP')

@section('content')

    <button id="locateBtn">📍 Me localiser</button>

    <div class="info" id="info" style="display: none;">
        <p><strong>IP :</strong> <span id="ip"></span></p>
        <p><strong>Pays :</strong> <span id="country"></span></p>
        <p><strong>Ville :</strong> <span id="city"></span></p>
        <p><strong>Latitude :</strong> <span id="lat"></span></p>
        <p><strong>Longitude :</strong> <span id="lon"></span></p>
        <p><strong>ID Enregistrement :</strong> <span id="record_id"></span></p>
    </div>

    <div id="map"></div>

@endsection

@push('scripts')
<script>
    const btn = document.getElementById('locateBtn');
    const infoBlock = document.getElementById('info');
    let map = L.map('map').setView([0, 0], 2);
    let marker = null;

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
    }).addTo(map);

    btn.addEventListener('click', () => {
        btn.disabled = true;
        btn.textContent = "🔄 Localisation en cours...";

        fetch('/locate-by-ip', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'ok') {
                infoBlock.style.display = 'block';
                document.getElementById('ip').textContent = data.ip;
                document.getElementById('country').textContent = data.country;
                document.getElementById('city').textContent = data.city;
                document.getElementById('lat').textContent = data.latitude;
                document.getElementById('lon').textContent = data.longitude;
                document.getElementById('record_id').textContent = data.record_id;

                const latlng = [data.latitude, data.longitude];
                if (marker) map.removeLayer(marker);
                marker = L.marker(latlng).addTo(map)
                    .bindPopup(`${data.city}, ${data.country}`).openPopup();
                map.setView(latlng, 10);
            } else {
                alert('Erreur: ' + data.message);
            }
            btn.disabled = false;
            btn.textContent = "📍 Me localiser";
        })
        .catch(err => {
            alert('Erreur serveur ou réseau');
            btn.disabled = false;
            btn.textContent = "📍 Me localiser";
            console.error(err);
        });
    });
</script>
@endpush
