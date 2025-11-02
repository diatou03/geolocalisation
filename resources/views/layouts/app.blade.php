<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'NAP AK KARANGUE')</title>

  <!-- Bootstrap CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    body {
      overflow-x: hidden;
      font-family: 'Roboto', sans-serif;
      background-color: #f5f6fa;
      padding-top: 16vh; /* espace pour navbar fixe */
    }

    /* --- Navbar fixe et centrée --- */
    .navbar-custom {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 16vh;
      background-color: rgb(12, 72, 141);
      display: flex;
      align-items: center;
      z-index: 1030;
      padding: 0 1rem;
    }

    .navbar-container {
      position: relative;
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .navbar-brand {
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      font-weight: bold;
      color: #fff;
      text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
      white-space: nowrap;
      font-size: 1.8rem;
      text-align: center;
    }

    .navbar-toggler { z-index: 1050; }

    /* --- Sidebar --- */
    .sidebar {
      position: fixed;
      top: 16vh; /* après navbar */
      left: 0;
      height: calc(100vh - 16vh);
      width: 250px;
      background-color: #0d0056e3;
      color: white;
      padding: 1rem;
      overflow-y: auto;
      transition: all 0.3s;
      z-index: 1020;
    }

    .sidebar.collapsed { width: 70px; }

    .sidebar .nav-link {
      color: white;
      font-weight: 500;
      display: flex;
      align-items: center;
      transition: all 0.3s;
    }

    .sidebar .nav-link.active,
    .sidebar .nav-link:hover {
      background-color: #9b5f04f6;
      color: #ffc107;
      border-radius: 0.25rem;
    }

    .sidebar .nav-link .menu-icon,
    .sidebar .nav-link img {
      width: 20px;
      height: 20px;
      margin-right: 10px;
      object-fit: contain;
      vertical-align: middle;
      transition: transform 0.3s;
    }

    .sidebar .nav-link:hover .menu-icon,
    .sidebar .nav-link:hover img { transform: scale(1.2); }

    .sidebar::-webkit-scrollbar { width: 6px; }
    .sidebar::-webkit-scrollbar-thumb { background-color: #ffc107; border-radius: 3px; }

    /* --- Main content --- */
    main.content {
      margin-left: 250px;
      padding: 2rem;
      min-height: calc(100vh - 16vh);
      transition: margin-left 0.3s;
    }
    .pirogue {
  filter: brightness(0) invert(1); /* rend blanc sur fond sombre */
  transition: transform 0.3s, filter 0.3s;
}

.nav-link.active .pirogue,
.nav-link:hover .pirogue {
  transform: scale(1.2);
  filter: brightness(0) saturate(100%) invert(89%) sepia(95%) saturate(5791%) hue-rotate(2deg) brightness(101%) contrast(101%);
}


    .sidebar.collapsed ~ main.content { margin-left: 70px; }

    /* --- Responsive --- */
    @media (max-width: 992px) {
      .sidebar { left: -250px; }
      .sidebar.show { left: 0; }
      main.content { margin-left: 0; }
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
  <div class="navbar-container">
    <!-- Toggler gauche -->
    <button class="navbar-toggler" type="button" aria-label="Toggle sidebar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Titre centré -->
    <a class="navbar-brand fw-bold" href="#">NAP AK KARANGUE</a>

    <!-- Dropdown utilisateur droite -->
    <div class="ms-auto">
      <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white dropdown-toggle" id="userMenu"
           data-bs-toggle="dropdown" aria-expanded="false">
          <img src="https://via.placeholder.com/32" class="rounded-circle" alt="utilisateur">
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
          <li><h6 class="dropdown-header">Utilisateur</h6></li>
          <li><a class="dropdown-item" href="#">Profil</a></li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="dropdown-item">Déconnexion</button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebarCanvas">
    <h4 class="text-center mb-4">MENU</h4>
    <ul class="nav flex-column">
      @php
        $menuItems = [
          ['label' => 'Tableau de bord', 'route' => 'dashboard', 'icon' => 'bi-house-door'],
          ['label' => 'Alertes', 'route' => 'alertes.index', 'icon' => 'bi-bell'],
          ['label' => 'Pirogues', 'route' => 'pirogues.index', 'icon' => 'bi-boat'],
          ['label' => 'GPS', 'route' => 'gps.map', 'icon' => 'bi-geo-alt'],
          ['label' => 'Positions', 'route' => 'positions.map', 'icon' => 'bi-geo-alt'],
          ['label' => 'Météo', 'route' => 'weather.show', 'icon' => 'bi-cloud-rain'],
          ['label' => 'Marées', 'route' => 'tides.index', 'icon' => 'bi-water'],
          ['label' => 'Agents marins', 'route' => 'agent_marins.index', 'icon' => 'bi-person']
        ];
      @endphp

      @foreach($menuItems as $item)
        @php $isActive = request()->routeIs($item['route']) ? 'active' : ''; @endphp
        <li class="nav-item mb-1">
          <a href="{{ route($item['route']) }}" class="nav-link {{ $isActive }}">
            @if ($item['label'] === 'Pirogues')
              <img src="{{ asset('images/pirogue.png') }}" alt="Pirogue" class="pirogue">
            @else
              <i class="bi {{ $item['icon'] }} me-2 menu-icon"></i>
            @endif
            {{ $item['label'] }}
          </a>
        </li>
      @endforeach
    </ul>
  </div>

  <!-- Main content -->
  <main class="content">
    @yield('content')
  </main>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Script toggle sidebar mobile -->
  <script>
    const sidebar = document.getElementById('sidebarCanvas');
    const toggler = document.querySelector('.navbar-toggler');

    toggler.addEventListener('click', () => {
      sidebar.classList.toggle('show');
    });
  </script>

</body>
</html>
