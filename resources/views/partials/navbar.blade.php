<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Navbar centrée</title>
  <!-- Lien vers Bootstrap CSS (v5) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    .navbar-custom .navbar-brand {
      position: absolute;
      left: 75%;
      transform: translateX(-20%);
      /* Si tu veux que le texte soit centré même en petit écran */
      white-space: nowrap;
      /* taille augmentée */
      font-size: 2.5rem; /* valeur par défaut */
      font-weight: 800;
    }

    /* Ajustements responsive pour le titre */
    @media (max-width: 576px) {
      .navbar-custom .navbar-brand {
        font-size: 2.3rem;
      }
    }

    @media (min-width: 992px) {
      .navbar-custom .navbar-brand {
        font-size: 2.75rem;
      }
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom px-3">
  <div class="container-fluid px-0">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu"
      aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <a class="navbar-brand fw-bold" href="#">NAP AK KARANGUE</a>

    <div class="collapse navbar-collapse justify-content-end" id="navMenu">
      <!-- Met ici tes liens de navigation si besoin -->
    </div>

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

<!-- Script Bootstrap (JS + Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
