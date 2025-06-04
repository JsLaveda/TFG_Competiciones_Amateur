<?php
session_start();
$usuario = $_SESSION['usuario']['nombre_usuario'] ?? 'Usuario';
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
      min-height: 100vh;
      background: linear-gradient(135deg, #e3eafc, #cfd9ff);
      padding-top: 70px;
    }
  </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">🏆 Competiciones</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="menuPrincipal">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controlador=Estadisticas&accion=estadisticasFutbol">Competiciones</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controlador=Competicion&accion=crear">Crear Competición</a>
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
  </nav>

  <div class="container text-center">
    <h1 class="fw-bold">Bienvenido, <?= htmlspecialchars($usuario) ?> 👋</h1>
    <p class="lead">Estás en el panel principal. Usa el menú de arriba para gestionar tus competiciones.</p>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
