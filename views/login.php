<h2>Iniciar Sesión</h2>

<form action="index.php?controlador=User&accion=login" method="post">
    <label>Nombre de usuario:</label>
    <input type="text" name="nombre_usuario" required><br>

    <label>Contraseña:</label>
    <input type="password" name="contraseña" required><br>

    <input type="submit" value="Entrar">
</form>
