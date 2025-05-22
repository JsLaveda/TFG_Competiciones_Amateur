<h2>Registro de Usuario</h2>

<form action="index.php?controlador=User&accion=register" method="post">
    <label>Nombre de usuario:</label>
    <input type="text" name="nombre_usuario" required><br>

    <label>Nombre completo:</label>
    <input type="text" name="nombre" required><br>

    <label>Email:</label>
    <input type="email" name="email" required><br>

    <label>Contraseña:</label>
    <input type="password" name="contraseña" minlength="6" required><br>

    <input type="submit" value="Registrarse">
</form>
