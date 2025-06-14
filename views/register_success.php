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
      background: linear-gradient(135deg, #198754, #0dcaf0);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
    }

    .success-box {
      background: rgba(0, 0, 0, 0.2);
      padding: 2.5rem;
      border-radius: 1rem;
      text-align: center;
      max-width: 500px;
      width: 100%;
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
