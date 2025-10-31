<div id="map" style="height:600px;"></div>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
  const map = L.map('map').setView([14.7, -16.9], 6);   // centre Sénégal
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

  @foreach ($readings as $r)
    L.marker([{{ $r->lat }}, {{ $r->lng }}])
      .bindPopup("{{ $r->device_id }}<br>{{ $r->captured_at }}")
      .addTo(map);
  @endforeach
</script>
