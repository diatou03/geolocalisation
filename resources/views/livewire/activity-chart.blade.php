<canvas id="activityChart"></canvas>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('livewire:load', function () {
    const ctx = document.getElementById('activityChart').getContext('2d');
    const labels = @json(array_keys($data));
    const counts = @json(array_values($data));

    new Chart(ctx, {
      type: 'line',
      data: {
        labels,
        datasets: [{
          label: 'Alertes',
          data: counts,
          backgroundColor: 'rgba(255,99,132,0.2)',
          borderColor: 'rgba(255,99,132,1)',
          fill: true,
          tension: 0.3
        }]
      },
      options: { responsive: true }
    });
  });
</script>
@endpush
