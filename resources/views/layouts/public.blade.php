<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Nap ak karangue')</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      background-color: #f4f9ff;
      font-family: 'Poppins', sans-serif;
      overflow-x: hidden;
    }

    /* Navbar fixe */
    nav.navbar {
      background-color: #004b8d;
      padding: 0.8rem 1rem;
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1030; /* Toujours au-dessus du contenu */
    }
    .navbar-brand {
      font-weight: bold;
      color: white !important;
      letter-spacing: 1px;
    }
    .navbar-nav .nav-link {
      color: white !important;
      font-weight: 500;
    }
    .btn-login, .btn-register {
      border-radius: 20px;
      padding: 6px 15px;
      font-weight: 600;
    }
    .btn-login {
      background-color: #fff;
      color: #004b8d;
    }
    .btn-login:hover {
      background-color: #e6f2ff;
    }
    .btn-register {
      background-color: #f7b84b;
      color: #fff;
    }
    .btn-register:hover {
      background-color: #e0a940;
    }

    /* Footer */
    footer {
      background: #004b8d;
      color: #fff;
      text-align: center;
      padding: 1rem 0;
      margin-top: 3rem;
    }

    /* Pour éviter que le contenu soit caché par la navbar fixe */
    main.container {
      padding-top: 80px; /* hauteur approximative de la navbar */
      padding-bottom: 30px;
    }

    /* Responsive pour les boutons dans la navbar */
    @media (max-width: 576px) {
      .navbar-nav {
        gap: 0.5rem;
      }
      .btn-login, .btn-register {
        padding: 5px 10px;
        font-size: 0.9rem;
      }
    }
  </style>

  @yield('styles')
</head>
<body>

  <!-- Navbar publique -->
  <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="{{ url('/') }}">
       Bienvenue sur la plateforme 🌊 Nap Ak karangue
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
        aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex align-items-center gap-2">
          <li class="nav-item">
            <a href="{{ route('login') }}" class="btn btn-login">
              <i class="fa-solid fa-right-to-bracket"></i> Se connecter
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('register') }}" class="btn btn-register">
              <i class="fa-solid fa-user-plus me-2"></i> S'inscrire
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Contenu principal -->
  <main class="container">
    @yield('content')
  </main>

  <!-- Footer -->
  <footer>
    &copy; {{ date('Y') }} Nap ak karangue — Sécurité en mer 🌊
  </footer>

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  @yield('scripts')
</body>
</html>
