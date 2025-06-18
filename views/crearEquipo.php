<?php 
$competicion_id = $_GET['competicion_id'] ?? null;
$error = $_GET['error'] ?? null;
$success = $_GET['success'] ?? null;
$equiposExistentes = $equiposExistentes ?? [];
$usuarioNombre = $_SESSION['usuario']['nombre'] ?? 'Usuario';
$titulo = "Añadir Equipos";

if (!$competicion_id) {
    echo "ID de competición no especificado.";
    exit();
}

ob_start();
?>

<h1 class="titulo-equipo mb-4">Añadir Equipos a la Competición</h1>

<div class="form-container bg-white p-4 rounded shadow w-100" style="max-width: 600px;">

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <?php if ($success): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <!-- EQUIPOS YA CREADOS -->
  <?php if (!empty($equiposExistentes)): ?>
    <h4 class="text-dark mb-3">Equipos ya creados</h4>
    <ul class="list-group mb-4">
      <?php foreach ($equiposExistentes as $equipo): ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <span><?= htmlspecialchars($equipo->getNombre()) ?></span>
          <div class="btn-group">
            <a href="index.php?controlador=equipo&accion=editarEquipo&id_equipo=<?= $equipo->getId_equipo() ?>" class="btn btn-sm btn-outline-primary">Editar</a>
            <a href="index.php?controlador=equipo&accion=eliminarEquipo&id_equipo=<?= $equipo->getId_equipo() ?>&competicion_id=<?= $competicion_id ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Estás seguro de eliminar este equipo?')">Eliminar</a>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <!-- FORMULARIO PARA NUEVOS EQUIPOS -->
  <form method="POST" action="index.php?controlador=equipo&accion=crearEquipo&competicion_id=<?= htmlspecialchars($competicion_id) ?>">
    <input type="hidden" name="competicion_id" value="<?= htmlspecialchars($competicion_id) ?>">

    <div class="mb-3 input-group">
      <input type="text" class="form-control" name="equipos[]" placeholder="Nombre del Equipo 1" required>
    </div>

    <div class="mb-3 input-group">
      <input type="text" class="form-control" name="equipos[]" placeholder="Nombre del Equipo 2" required>
    </div>

    <div id="nuevosEquipos"></div>

    <div class="d-grid gap-2 d-md-flex justify-content-md-between mt-3">
      <button type="button" class="btn btn-secondary" onclick="añadirEquipo()">+ Añadir otro equipo</button>
      <button type="submit" class="btn btn-success">Guardar Equipos</button>
    </div>
  </form>
</div>

<script>
  let contadorEquipos = 3;

  function añadirEquipo() {
    const container = document.getElementById("nuevosEquipos");
    const divEquipo = document.createElement("div");
    divEquipo.classList.add("mb-3", "input-group");

    divEquipo.innerHTML = `
      <input type="text" class="form-control" name="equipos[]" required placeholder="Nombre del Equipo ${contadorEquipos}">
      <button type="button" class="btn btn-danger" onclick="eliminarEquipo(this)">Eliminar</button>
    `;

    container.appendChild(divEquipo);
    contadorEquipos++;
  }

  function eliminarEquipo(boton) {
    boton.parentElement.remove();
  }
</script>

<?php
$contenido = ob_get_clean();
include 'views/layouts/layout.php';
?>
