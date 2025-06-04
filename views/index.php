<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Competiciones Amateur</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      min-height: 100vh;
      background: url('views/fotos/index_principal.avif') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
    }

    .contenido {
      color: white;
      text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.8);
    }

    .btn {
      width: 200px;
    }
  </style>
</head>
<body>

  <div class="contenido">
    <h1 class="mb-4 fw-bold">¡Bienvenido a Competiciones Amateur!</h1>
    <div class="d-flex flex-column align-items-center gap-3">
      <a href="index.php?controlador=User&accion=register" class="btn btn-primary">Registrarse</a>
      <a href="index.php?controlador=Estadisticas&accion=estadisticasFutbol" class="btn btn-success">Ver estadísticas</a>
      <a href="index.php?controlador=User&accion=login" class="btn btn-secondary">Iniciar sesión</a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
