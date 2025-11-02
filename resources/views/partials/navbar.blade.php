<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Navbar Fixe</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    /* --- Barre fixée --- */
    .navbar-custom {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 1030; /* au-dessus des autres éléments */
      background-color: #004b8d !important;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    /* --- Titre centré --- */
    .navbar-brand-center {
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      font-size: 2rem;
      font-weight: 800;
      color: white !important;
      white-space: nowrap;
    }

    /* --- Ajustement responsive --- */
    @media (max-width: 576px) {
      .navbar-brand-center {
        font-size: 1.5rem;
      }
    }

    /* --- Espace en haut du contenu --- */
    body {
      padding-top: 80px; /* pour éviter que le contenu soit caché sous la navbar */
      background-color: #f8f9fa;
    }

    /* --- Dropdown utilisateur à droite --- */
    .user-dropdown {
      margin-left: auto;
    }
  </style>
</head>
<body>

  <!-- 🔹 Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark navbar-custom px-3">
    <div class="container-fluid position-relative">
      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu"
        aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Titre centré -->
      <a class="navbar-brand navbar-brand-center" href="#">NAP AK KARANGUE</a>

      <!-- Menu gauche / droit -->
      <div class="collapse navbar-collapse justify-content-end" id="navMenu">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link text-white" href="#">Accueil</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="#">Météo</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="#">Marées</a></li>
        </ul>

        <!-- Dropdown utilisateur -->
        <div class="dropdown user-dropdown">
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

  <!-- 🔹 Contenu -->
  <div class="container mt-5">
    <h1>Bienvenue sur Nap Ak Karangue 🌊</h1>
    <p>Contenu de la page ici...</p>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
