<?php
//define('__ROOT__', dirname(__FILE__, 2));
//
//require_once __ROOT__ . "/vendor/autoload.php";
//require_once __ROOT__ . "/App/Controller/PropertyTypeController.php";
//require_once __ROOT__ . "/App/Controller/HomeController.php";
//
//$routes = [
//    "/a" => [App\Controller\HomeController::class, "index"],
//    "/home" => [App\Controller\HomeController::class, "index"],
//    "/property-types" => [App\Controller\PropertyTypeController::class, "index"],
//];
//
//$url = $_SERVER['REQUEST_URI'];
//
//session_start();
//
//if (array_key_exists($url, $routes)) {
//    [$controller, $method] = $routes[$url];
//    echo $controller, " ",  $method;
//    $controller = new $controller();
//    $controller->$method();
//} else {
//    echo "404";
//}
