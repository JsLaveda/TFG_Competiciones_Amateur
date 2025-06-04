<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php?controller=User&action=login'); 
    //la ruta de arriba -^^^- debe ser la de inicio de sesión para obligar al usuario a iniciarla
    exit();
}
