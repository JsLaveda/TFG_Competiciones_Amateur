<?php
$competicion = $competicion ?? null;
$estado = $estado ?? 'pendiente';
$usuarioNombre = $_SESSION['usuario']['nombre'] ?? 'Usuario';

if (!$competicion) {
    echo "<div class='alert alert-danger text-center mt-5'>Error: Competición no encontrada.</div>";
    return;
}

$tipoRaw = $competicion->getTipo_competicion();
switch ($tipoRaw) {
    case '1':
    case 'baloncesto':
        $tipoTexto = 'Baloncesto';
        break;
    case '2':
    case 'futbol':
    default:
        $tipoTexto = 'Fútbol';
        break;
}

$privacidadRaw = $competicion->getPrivacidad();
$privacidadTexto = ($privacidadRaw == '1') ? 'Privada' : 'Pública';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Vista de Competición</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      background: linear-gradient(135deg, #e3eafc, #cfd9ff);
      min-height: 100vh;
      position: relative;
      z-index: 0;
    }

    .hero-container {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      overflow: hidden;
      z-index: -1;
    }

    .hero-container img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0.2;
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

    .content-container {
      margin-top: 100px;
      max-width: 800px;
      margin-left: auto;
      margin-right: auto;
      background: white;
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>
<body>

<!-- Fondo -->
<div class="hero-container">
  <img src="views/fotos/futbol.avif" alt="Fondo fútbol">
</div>

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

<!-- CONTENIDO -->
<div class="content-container">
  <h1 class="text-center mb-4">Competición: <?= htmlspecialchars($competicion->getNombre()) ?></h1>

  <div class="card mb-4">
    <div class="card-body">
      <p class="card-text"><strong>Tipo:</strong> <?= $tipoTexto ?></p>
      <p class="card-text"><strong>Privacidad:</strong> <?= $privacidadTexto ?></p>
      <p class="card-text"><strong>Fechas:</strong> <?= htmlspecialchars($competicion->getFecha_inicio()) ?> a <?= htmlspecialchars($competicion->getFecha_fin()) ?></p>
      <p class="card-text"><strong>Estado:</strong> <?= htmlspecialchars($estado) ?></p>
    </div>
  </div>

  <?php if ($estado === 'pendiente'): ?>
    <div class="alert alert-warning text-center">El organizador aún no ha iniciado esta competición.</div>
  <?php else: ?>
    <a href="index.php?controlador=competicion&accion=clasificacion&id=<?= $competicion->getId_competicion() ?>" class="btn btn-success w-100">Ver Clasificación</a>
  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
