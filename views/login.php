<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar Sesión</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      min-height: 100vh;
      margin: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }

    body::before {
      content: "";
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: url('views/fotos/futbol2.avif') no-repeat center center fixed;
      background-size: cover;
      opacity: 0.5; /* Puedes ajustar la opacidad aquí */
      z-index: -1;
    }

    .login-box {
  background: transparent; /* <-- Quitamos el blanco */
  padding: 2rem;
  border-radius: 1rem;
  box-shadow: none; /* Opcional: quitar sombra también */
  width: 100%;
  max-width: 400px;
  position: relative;
  z-index: 1;
}

  </style>
</head>
<body>

  <div class="login-box">
    <h2 class="text-center mb-4">Iniciar Sesión</h2>

    <?php if (!empty($mensaje)) : ?>
      <div class="alert alert-danger text-center">
        <?= htmlspecialchars($mensaje) ?>
      </div>
    <?php endif; ?>

    <form action="index.php?controlador=User&accion=login" method="post">
      <div class="mb-3">
        <label for="usuario" class="form-label">Nombre de usuario</label>
        <input type="text" class="form-control" id="usuario" name="nombre_usuario" required>
      </div>

      <div class="mb-3">
        <label for="contraseña" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="contraseña" name="contraseña" required>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-primary">Entrar</button>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
