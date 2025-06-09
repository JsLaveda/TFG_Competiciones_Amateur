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
      background: linear-gradient(135deg, #6c757d, #343a40);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-box {
      background: white;
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 0 20px rgba(0,0,0,0.2);
      width: 100%;
      max-width: 400px;
    }
  </style>
</head>
<body>

  <div class="login-box">
    <h2 class="text-center mb-4">Iniciar Sesión</h2>

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
