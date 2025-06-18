<?php
$usuarioNombre = $usuario['nombre'] ?? 'Usuario';
$titulo = "Panel Principal";

ob_start(); // Inicia el buffer de salida
?>

<h1 class="text-white mb-5">Bienvenido, <?= htmlspecialchars($usuarioNombre) ?> 👋</h1>

<div class="d-flex flex-column gap-3">
  <a href="index.php?controlador=Competicion&accion=crearCompeticion&tipo=futbol" class="btn btn-success btn-lg">
    ⚽ Crear competición de fútbol
  </a>
  <a href="index.php?controlador=Competicion&accion=crearCompeticion&tipo=baloncesto" class="btn btn-primary btn-lg">
    🏀 Crear competición de baloncesto
  </a>
</div>

<?php
$contenido = ob_get_clean(); // Guarda el contenido generado
include 'views/layouts/layout.php'; // Renderiza dentro del layout
