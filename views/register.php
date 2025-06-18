<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Usuario</title>
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
  background-image: url('views/fotos/futbol2.avif');
  background-size: cover;
  background-position: center;
  opacity: 0.3; /* Ajusta la opacidad aquí */
  z-index: -1;
}

  </style>
</head>
<body>

  <div class="register-box">
    <h2 class="text-center mb-4">Registro de Usuario</h2>

    <form action="index.php?controlador=User&accion=register" method="post">
      <div class="mb-3">
        <label for="nombre_usuario" class="form-label">Nombre de usuario</label>
        <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required>
      </div>

      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre completo</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Correo electrónico</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>

      <div class="mb-3">
        <label for="contraseña" class="form-label">Contraseña (mín. 6 caracteres)</label>
        <input type="password" class="form-control" id="contraseña" name="contraseña" minlength="6" required>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-success">Registrarse</button>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
