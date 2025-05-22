<?php
class FrontController
{
    static function main()
{
    require 'libs/Config.php';
    require 'libs/SPDO.php';
    require 'libs/View.php';
    require 'setup.php';

    $config = Config::singleton(); 

    if (!empty($_GET['controlador']))
        $controllerName = $_GET['controlador'] . 'Controller';
    else
        $controllerName = "IndexController";

    if (!empty($_GET['accion']))
        $actionName = $_GET['accion'];
    else
        $actionName = "index";

    $controllerPath = $config->get('controllersFolder') . $controllerName . '.php';

    if (is_file($controllerPath))
        include($controllerPath);
    else
        die('El controlador no existe - 404 not found');

    if (!(class_exists($controllerName) && method_exists($controllerName, $actionName))) {
        trigger_error($controllerName . '->' . $actionName . ' no existe', E_USER_NOTICE);
        return false;
    }

    $controller = new $controllerName();
    $controller->$actionName();
}

}
?>