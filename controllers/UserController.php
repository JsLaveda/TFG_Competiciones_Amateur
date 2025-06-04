<?php
require_once 'models/UsuarioModel.php';

class UserController
{
    public function index()
    {
        $vista = new View();
        $vista->show("register.php");
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre_usuario = $_POST['nombre_usuario'];
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $contraseña = $_POST['contraseña'];

            $contraseña_hash = password_hash($contraseña, PASSWORD_BCRYPT);

            $usuario = new UsuarioModel();
            $usuario->setNombre_usuario($nombre_usuario);
            $usuario->setNombre($nombre);
            $usuario->setEmail($email);
            $usuario->setContraseña($contraseña_hash);
            $ok = $usuario->save();

            if ($ok) {
                echo "Usuario registrado correctamente.";
            } else {
                echo "Error al registrar usuario.";
            }
        } else {
            $vista = new View();
            $vista->show("register.php");
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre_usuario = $_POST['nombre_usuario'];
            $contraseña = $_POST['contraseña'];

            $usuarioLogin = new UsuarioModel();
            $usuario = $usuarioLogin->verificarLogin($nombre_usuario, $contraseña);

            if ($usuario) {
                session_start();
                $_SESSION['usuario'] = $usuario;
                echo "Sesión iniciada correctamente. Bienvenido, " . $usuario['nombre'];
                // También podrías redirigir:
                // header('Location: index.php');
            } else {
                echo "Nombre de usuario o contraseña incorrectos.";
            }
        } else {
            $vista = new View();
            $vista->show("login.php");
        }
    }
}
