<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<div id="map" style="height: 500px;"></div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const map = L.map('map').setView([0, 0], 2);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors',
      maxZoom: 18,
    }).addTo(map);

    const positions = @json($positions);

    positions.forEach(pos => {
      const marker = L.marker([pos.latitude, pos.longitude]).addTo(map);
      let popup = `<strong>${pos.pirogue_nom}</strong><br>${pos.message ?? ''}<br>${pos.created_at}`;
      marker.bindPopup(popup);
    });

    if (positions.length) {
      const group = positions.map(p => [p.latitude, p.longitude]);
      map.fitBounds(group);
    }
  });
</script>
<x-maps-leaflet 
  :centerPoint="['lat'=>0,'long'=>0]" 
  :markers="$positions->map(fn($p)=>['lat'=>$p['latitude'],'lng'=>$p['longitude'],'info'=>\"{$p['pirogue_nom']} – {$p['message']}\"])"/>

