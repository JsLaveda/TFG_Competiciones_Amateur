<?php
session_start();
$usuario = $_SESSION['usuario']['nombre'] ?? 'Usuario';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel Principal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      background: linear-gradient(135deg, #e3eafc, #cfd9ff);
    }

    .hero-container {
      position: relative;
      width: 100%;
      height: 100vh;
      overflow: hidden;
    }

    .hero-container img {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0.25;
    }

    .hero-text {
      position: absolute;
      top: 20%;
      left: 50%;
      transform: translateX(-50%);
      color: #000;
      text-shadow: 0px 1px 3px rgba(255, 255, 255, 0.8);
      font-weight: bold;
      text-align: center;
    }

    .hero-text h1 {
      font-size: 2.5rem;
      margin-bottom: 2rem;
    }

    .btn-group-custom {
      position: absolute;
      top: 45%;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 1rem;
    }

    .btn-group-custom a {
      width: 250px;
    }

    .navbar .navbar-nav .nav-link {
      margin-left: 15px;
      margin-right: 15px;
    }

    .navbar-brand {
      display: flex;
      align-items: center;
      font-size: 1.25rem;
      margin-right: 40px;
    }

    .fixed-top {
      z-index: 10;
    }
  </style>
</head>
<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container d-flex justify-content-center">
      <div class="d-flex align-items-center">
        <a class="navbar-brand fw-bold" href="#">🏆 Competiciones</a>
        <div class="collapse navbar-collapse show" id="menuPrincipal">
          <ul class="navbar-nav d-flex flex-row align-items-center">
            <li class="nav-item">
              <a class="nav-link" href="index.php?controlador=Estadisticas&accion=estadisticasFutbol">Competiciones</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php?controlador=User&accion=register">Registro</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php?controlador=User&accion=logout">Cerrar sesión</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <!-- IMAGEN PRINCIPAL -->
  <div class="hero-container">
    <img src="views/fotos/index_principal.avif" alt="Imagen de fondo">

    <!-- TEXTO SUPERIOR -->
    <div class="hero-text">
      <h1>Bienvenido, <?= htmlspecialchars($usuario) ?> 👋</h1>
    </div>

    <!-- BOTONES -->
    <div class="btn-group-custom">
      <a href="index.php?controlador=Competicion&accion=crearFutbol" class="btn btn-success btn-lg">
        ⚽ Crear competición de fútbol
      </a>
      <a href="index.php?controlador=Competicion&accion=crearBaloncesto" class="btn btn-primary btn-lg">
        🏀 Crear competición de baloncesto
      </a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
