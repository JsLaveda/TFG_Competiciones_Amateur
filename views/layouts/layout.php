<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?= $titulo ?? 'Panel' ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
    }

    .hero-container {
      position: relative;
      width: 100%;
      height: 100vh;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      z-index: 1;
    }

    .hero-container::before {
      content: "";
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: url('views/fotos/futbol2.avif') no-repeat center center fixed;
      background-size: cover;
      opacity: 0.5;
      z-index: -1;
    }

    .navbar {
      background-color: rgba(0, 0, 0, 0.6) !important;
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .navbar .navbar-brand,
    .navbar .nav-link {
      color: white !important;
      font-weight: 500;
      text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
      transition: color 0.3s ease;
    }

    .navbar .nav-link:hover {
      color: #0dcaf0 !important;
    }

    .navbar-nav {
      flex-direction: row !important;
      gap: 20px;
    }

    .navbar-brand {
      font-size: 1.4rem;
    }

    .fixed-top {
      z-index: 10;
    }

    .hero-content {
      position: relative;
      z-index: 1;
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg fixed-top">
  <div class="container d-flex flex-column align-items-center">
    
    <!-- Logo centrado -->
    <a class="navbar-brand fw-bold mb-2" href="#">🏆 Competiciones</a>
    
    <!-- Botones centrados debajo -->
    <div class="collapse navbar-collapse show justify-content-center" id="menuPrincipal">
      <ul class="navbar-nav d-flex flex-row justify-content-center align-items-center gap-4">
        <li class="nav-item">
          <a class="nav-link" href="index.php?controlador=Estadisticas&accion=estadisticasFutbol">Competiciones</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?controlador=User&accion=logout">Cerrar sesión</a>
        </li>
      </ul>
    </div>

  </div>
</nav>


  <!-- CONTENEDOR PRINCIPAL CON FONDO -->
  <div class="hero-container">
    <div class="hero-content">
      <?= $contenido ?? '' ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
