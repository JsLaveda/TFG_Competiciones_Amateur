<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    header('Location: index.php?controller=User&action=login');
    //la ruta de arriba -^^^- debe ser la de inicio de sesión para obligar al usuario a iniciarla
    exit();
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");
