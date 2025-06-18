<?php
$competicion = $competicion ?? null;
$estado = $estado ?? 'pendiente';
$usuarioNombre = $_SESSION['usuario']['nombre'] ?? 'Usuario';
$titulo = "Gestión de tu Competición";

if (!$competicion) {
    echo "<div class='alert alert-danger text-center mt-5'>Error: Competición no encontrada.</div>";
    return;
}

// Texto del tipo de competición
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

ob_start();
?>

<h1 class="titulo-equipo mb-4">Competición que has creado</h1>

<div class="bg-white p-4 rounded shadow w-100" style="max-width: 800px;">
  <div class="card mb-4">
    <div class="card-body">
      <h5 class="card-title">Nombre: <?= htmlspecialchars($competicion->getNombre()) ?></h5>
      <p class="card-text"><strong>Tipo:</strong> <?= $tipoTexto ?></p>
      <p class="card-text"><strong>Privacidad:</strong> <?= $privacidadTexto ?></p>
      <p class="card-text"><strong>Fechas:</strong> <?= htmlspecialchars($competicion->getFecha_inicio()) ?> a <?= htmlspecialchars($competicion->getFecha_fin()) ?></p>
      <p class="card-text"><strong>Estado:</strong> <?= htmlspecialchars($estado) ?></p>
    </div>
  </div>

  <?php if ($estado === 'pendiente'): ?>
    <div class="alert alert-warning text-center">La competición aún no ha comenzado.</div>
    <div class="d-grid gap-2">
      <a href="index.php?controlador=competicion&accion=inicioCompeticion&id=<?= $competicion->getId_competicion() ?>" class="btn btn-primary">Iniciar Competición</a>
      <a href="index.php?controlador=equipo&accion=crearEquipo&competicion_id=<?= $competicion->getId_competicion() ?>" class="btn btn-outline-secondary">Añadir más equipos</a>
    </div>
  <?php elseif ($estado === 'iniciada'): ?>
    <div class="alert alert-success text-center">¡Competición en curso!</div>
    <a href="index.php?controlador=competicion&accion=clasificacion&id=<?= $competicion->getId_competicion() ?>" class="btn btn-success w-100">Ver Clasificación</a>
  <?php elseif ($estado === 'finalizada'): ?>
    <div class="alert alert-dark text-center">Competición finalizada</div>
    <a href="index.php?controlador=competicion&accion=clasificacion&id=<?= $competicion->getId_competicion() ?>" class="btn btn-secondary w-100">Ver Clasificación Final</a>
  <?php endif; ?>
</div>

<?php
$contenido = ob_get_clean();
include 'views/layouts/layout.php';
?>
