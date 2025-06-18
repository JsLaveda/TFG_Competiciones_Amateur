<?php 
$tipo = $_GET['tipo'] ?? 'futbol';
$error = $_GET['error'] ?? '';
$nombreGuardado = $_GET['nombre'] ?? '';
$fechaInicioGuardada = $_GET['fecha_inicio'] ?? '';
$fechaFinGuardada = $_GET['fecha_fin'] ?? '';
$usuarioNombre = $_SESSION['usuario']['nombre'] ?? 'Usuario';

$titulo = "Crear Competición";
$actionURL = "index.php?controlador=competicion&accion=crearCompeticion&tipo=" . urlencode($tipo);

ob_start();
?>

<h1 class="titulo-equipo mb-4">Crear nueva competición</h1>

<div class="form-container bg-white p-4 rounded shadow w-100" style="max-width: 600px;">
  <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" action="<?= $actionURL ?>" onsubmit="return validarFechas()">
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre de la Competición</label>
      <input type="text" name="nombre" id="nombre" class="form-control" required value="<?= htmlspecialchars($nombreGuardado) ?>">
    </div>

    <div class="mb-3">
      <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
      <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required value="<?= htmlspecialchars($fechaInicioGuardada) ?>">
    </div>

    <div class="mb-3">
      <label for="fecha_fin" class="form-label">Fecha de Fin</label>
      <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" required value="<?= htmlspecialchars($fechaFinGuardada) ?>">
    </div>

    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" id="privacidad" name="privacidad">
      <label class="form-check-label" for="privacidad">Competición Privada</label>
    </div>

    <input type="hidden" name="tipo_competicion" value="<?= htmlspecialchars($tipo) ?>">

    <div class="d-grid">
      <button type="submit" class="btn btn-primary">Crear Competición</button>
    </div>
  </form>
</div>

<script>
  function validarFechas() {
    const inicio = new Date(document.getElementById('fecha_inicio').value);
    const fin = new Date(document.getElementById('fecha_fin').value);
    if (fin < inicio) {
      alert("La fecha de fin no puede ser anterior a la de inicio.");
      return false;
    }
    return true;
  }
</script>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const hoy = new Date().toISOString().split("T")[0]; // Formato yyyy-mm-dd

    document.getElementById("fecha_inicio").setAttribute("min", hoy);
    document.getElementById("fecha_fin").setAttribute("min", hoy);
  });
</script>


<?php
$contenido = ob_get_clean();
include 'views/layouts/layout.php';
?>
