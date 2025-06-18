<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro exitoso</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      min-height: 100vh;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      color: white;
    }

    body::before {
      content: "";
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: url('views/fotos/futbol2.avif') no-repeat center center fixed;
      background-size: cover;
      opacity: 0.5; /* Ajusta si quieres más/menos visibilidad */
      z-index: -1;
    }

    .success-box {
      background: rgba(0, 0, 0, 0.3); /* Fondo semitransparente oscuro */
      backdrop-filter: blur(6px);     /* Difumina lo que hay detrás */
      padding: 2.5rem;
      border-radius: 1rem;
      text-align: center;
      max-width: 500px;
      width: 100%;
      position: relative;
      z-index: 1;
    }

    .btn-group .btn {
      margin: 0.5rem;
    }
  </style>
</head>
<body>

  <div class="success-box">
    <h2 class="mb-4">¡Te has registrado con éxito!</h2>

    <div class="btn-group d-flex flex-column align-items-center">
      <a href="dashboard.php" class="btn btn-light w-75">Ir a la página principal</a>
      <a href="index.php?controlador=User&accion=login" class="btn btn-outline-light w-75">Iniciar sesión con otro usuario</a>
      <a href="index.php?controlador=User&accion=logout" class="btn btn-danger w-75">Cerrar sesión</a>
    </div>
  </div>

</body>
</html>
