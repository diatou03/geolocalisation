<div class="bg-white p-6 rounded-lg shadow">
  <h2 class="text-xl font-semibold mb-3">Dernières Alertes</h2>
  <ul>
    @forelse($alerts as $a)
      <li class="mb-2 p-2 border-b">
        <strong>{{ $a->type }}</strong> — <small>{{ $a->niveau }}</small><br>
        <small>{{ $a->created_at->diffForHumans() }}</small>
      </li>
    @empty
      <li class="text-gray-500">Aucune alerte récente</li>
    @endforelse
  </ul>
</div>
