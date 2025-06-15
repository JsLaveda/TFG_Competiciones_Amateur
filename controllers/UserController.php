<?php
require_once 'models/UsuarioModel.php';
require_once 'models/CompeticionModel.php';

class UserController
{
    public function index()
    {
        $vista = new View();
        $vista->show("register.php");
    }

    public function register()
    {
        $vista = new View();
        $mensaje = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre_usuario = $_POST['nombre_usuario'];
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $contraseña = $_POST['contraseña'];

            $usuario = new UsuarioModel();

            if ($usuario->usuarioCorreoExistente($nombre_usuario, $email)) {
                $mensaje = "Error: Correo o nombre de usuario ya registrado.";
                $vista->show("register.php", ["mensaje" => $mensaje]);
                return;
            }

            $contraseña_hash = password_hash($contraseña, PASSWORD_BCRYPT);

            $usuario->setNombre_usuario($nombre_usuario);
            $usuario->setNombre($nombre);
            $usuario->setEmail($email);
            $usuario->setContraseña($contraseña_hash);
            $ok = $usuario->save();

            if ($ok) {
                header('Location: login.php');
                exit();
            } else {
                $mensaje = "Error al registrar usuario.";
                $vista->show("register.php", ["mensaje" => $mensaje]);
                return;
            }
        } else {
            $vista->show("register.php", ["mensaje" => $mensaje]);
        }
    }

    public function login()
    {
        $vista = new View();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre_usuario = $_POST['nombre_usuario'];
            $contraseña = $_POST['contraseña'];

            $usuarioLogin = new UsuarioModel();
            $usuario = $usuarioLogin->verificarLogin($nombre_usuario, $contraseña);

            if ($usuario) {
                session_start();
                $_SESSION['usuario'] = $usuario;

                // Redirige a página principal o dashboard
                header('Location: index.php?controller=usuario&action=dashboard');
                exit();
            } else {
                $mensaje = "Nombre de usuario o contraseña incorrectos.";
                $vista->show("login.php", ["mensaje" => $mensaje]);
                return;
            }
        } else {
            $vista->show("login.php");
        }
    }

    public function mostrarPaginaPrincipal()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario'])) {
            header('Location: index.php?controller=usuario&action=login');
            exit();
        }

        //Acceso despues de caché
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        $usuario = $_SESSION['usuario'];
        $competicionModel = new CompeticionModel();
        $competiciones = $competicionModel->getCompeticionesRandom(10);

        $vista = new View();
        $vista->show("dashboard.php", [
            'usuario' => $usuario,
            'competiciones' => $competiciones
        ]);
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();

        header('Location: index.php');
        exit();
    }
}
