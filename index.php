<?php
include 'System/AutoLoad.php';
$action = strtolower($_GET['action'] ?? 'index');
//TODO ProductController not productcontroller
$controllerName = ucwords(($_GET['controller'] ?? 'product') . 'Controller');

if (class_exists($controllerName)) {
    $controller = new $controllerName();
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        $controller->error404();
    }
} else {

    $controller = new Controller();
    $controller->error404();
}
