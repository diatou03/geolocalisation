<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'NAP AK KARANGUE')</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    body {
      overflow-x: hidden;
      font-family: 'Roboto', sans-serif;
      background-color: #f5f6fa;
    }

    /* --- Navbar --- */
    .navbar-custom {
      width: 100%;
      height: 16vh;
      background-color: rgb(12, 72, 141);
      display: flex;
      align-items: center;
    }

    .navbar-brand {
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      font-weight: bold;
      color: #fff;
      text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
    }

    .navbar-toggler {
      z-index: 200;
    }

    @media (min-width: 992px) {
      .navbar-toggler { display: none; }
    }

    /* --- Sidebar --- */
    .sidebar {
      position: fixed;
      top: 16vh;
      left: 0;
      height: 84vh;
      width: 250px;
      background-color: #0d0056e3;
      color: white;
      padding: 1rem;
      overflow-y: auto;
      transition: all 0.3s;
    }

    .sidebar.collapsed {
      width: 70px;
    }

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

    /* Uniformiser icônes */
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
    .sidebar .nav-link:hover img {
      transform: scale(1.2);
    }

    /* Sidebar scroll style */
    .sidebar::-webkit-scrollbar {
      width: 6px;
    }

    .sidebar::-webkit-scrollbar-thumb {
      background-color: #ffc107;
      border-radius: 3px;
    }

    /* --- Main content --- */
    main.content {
      margin-left: 250px;
      padding: 2rem;
      min-height: 84vh;
      transition: margin-left 0.3s;
    }

    .sidebar.collapsed ~ main.content {
      margin-left: 70px;
    }

    /* --- Pirogue icon --- */
    .pirogue {
      filter: brightness(0) invert(1);
      transition: filter 0.3s, transform 0.3s;
    }

    .nav-link.active .pirogue,
    .nav-link:hover .pirogue {
      filter: brightness(0) saturate(100%) invert(89%) sepia(95%) saturate(5791%) hue-rotate(2deg) brightness(101%) contrast(101%);
      transform: scale(1.2);
    }

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
  <nav class="navbar navbar-expand-lg navbar-dark navbar-custom px-3">
    <div class="container-fluid px-0">
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarCanvas"
        aria-controls="sidebarCanvas">
        <span class="navbar-toggler-icon"></span>
      </button>

      <a class="navbar-brand fw-bold" href="#">NAP AK KARANGUE</a>

      <div class="dropdown ms-auto">
        <a href="#" class="d-flex align-items-center text-white dropdown-toggle" id="userMenu"
           data-bs-toggle="dropdown" aria-expanded="false">
          <img src="https://via.placeholder.com/32" class="rounded-circle" alt="utilisateur">
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
          <li><h6 class="dropdown-header">Utilisateur</h6></li>
          <li><a class="dropdown-item" href="#">Profil</a></li>
          <li><div class="dropdown-divider"></div></li>
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="dropdown-item">Déconnexion</button>
            </form>
          </li>
        </ul>
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
           ['label' => 'Positions', 'route' => 'positions.json', 'icon' => 'bi-geo-alt'],
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
</body>
</html>
