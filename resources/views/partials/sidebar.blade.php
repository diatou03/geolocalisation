<div class="sidebar bg-dark-blue text-white p-3">
  <h4 class="text-center">MENU</h4>
  @php
    $menuItems = [
      ['label' => 'Tableau de bord', 'route' => 'dashboard', 'icon' => 'bi-house-door'],
      ['label' => 'Alertes', 'route' => 'alertes.index', 'icon' => 'bi-ship'],
      ['label' => 'Pirogues', 'route' => 'pirogues.index', 'icon' => 'bi-ship'],
      ['label' => 'GPS', 'route' => 'gps.map', 'icon' => 'bi-geo-alt'],
      ['label' => 'Positions', 'route' => 'positions.map', 'icon' => 'bi-geo-alt'],
      ['label' => 'Météo', 'route' => 'weather.show', 'icon' => 'bi-cloud-rain'],
      ['label' => 'Marées', 'route' => 'tides.index', 'icon' => 'bi-water'],
      ['label' => 'Agents marins', 'route' => 'agent_marins.index', 'icon' => 'bi-person']
    ];
  @endphp

  <ul class="nav flex-column">
    @foreach($menuItems as $item)
      @php
        $isActive = request()->routeIs($item['route']) ? 'active' : '';
      @endphp
      <li class="nav-item">
        <a href="{{ route($item['route']) }}" class="nav-link {{ $isActive }}">
          <i class="bi {{ $item['icon'] }}"></i> {{ $item['label'] }}
        </a>
      </li>
    @endforeach
  </ul>
</div>
