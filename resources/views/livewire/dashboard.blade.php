<div class="space-y-6">
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    @foreach($cards as $card)
      <x-dashboard-card 
        :href="$card['route']" 
        :icon="$card['icon']" 
        :title="$card['label']" 
        :color="$card['color']" 
        :count="$card['count']" />
    @endforeach
  </div>

  <div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-semibold mb-4">Activité récente</h2>
    <div class="mb-4 space-x-2">
      @foreach(['week'=>'Semaine','month'=>'Mois','year'=>'Année'] as $value => $label)
        <button wire:click="$set('period','{{ $value }}')" 
          class="px-4 py-2 border rounded @if($period === $value) bg-blue-500 text-white @else bg-gray-100 @endif">
          {{ $label }}
        </button>
      @endforeach
    </div>

    <livewire:activity-chart :period="$period" />
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <livewire:recent-alerts />
    <livewire:recent-pirogues />
  </div>
</div>
