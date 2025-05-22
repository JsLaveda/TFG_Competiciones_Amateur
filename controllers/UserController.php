<?php
require_once 'models/User.php';

class UserController {
    public function index() {
        $vista = new View();
        $vista->show("register.php");
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre_usuario = $_POST['nombre_usuario'];
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $contraseña = $_POST['contraseña'];

            $contraseña_hash = password_hash($contraseña, PASSWORD_BCRYPT);

            $user = new User();
            $ok = $user->save($nombre_usuario, $nombre, $email, $contraseña_hash);

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

    public function login() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre_usuario = $_POST['nombre_usuario'];
        $contraseña = $_POST['contraseña'];

        $user = new User();
        $usuario = $user->verificarLogin($nombre_usuario, $contraseña);

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
