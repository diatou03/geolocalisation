<template>
  <div id="map" style="width:100%; height:500px;"></div>
</template>

<script>
export default {
  props: {
    apiKey: String
  },
  data() {
    return {
      map: null,
      markers: {}
    };
  },
  mounted() {
    // Charger Google Maps de façon asynchrone
    const script = document.createElement('script');
    script.src = `https://maps.googleapis.com/maps/api/js?key=${this.apiKey}`;
    script.async = true;
    script.defer = true;
    script.onload = this.initMap;
    document.head.appendChild(script);
  },
  methods: {
    initMap() {
      this.map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: 0, lng: 0 },
        zoom: 8,
      });

      Echo.channel('localisations')
        .listen('LocalisationUpdated', e => {
          const { device_id, latitude, longitude } = e.loc;
          const pos = { lat: latitude, lng: longitude };
          if (!this.markers[device_id]) {
            this.markers[device_id] = new google.maps.Marker({ map: this.map, position: pos });
          } else {
            this.markers[device_id].setPosition(pos);
          }
          this.map.panTo(pos);
        });
    }
  }
};
</script>
