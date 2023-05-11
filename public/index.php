<?php
define('__ROOT__', dirname(__FILE__, 2));

require_once __ROOT__ . "/vendor/autoload.php";

$routes = [];
$webRoutes = [
    "" => [App\Controller\HomeController::class, "index"],
    "/" => [App\Controller\HomeController::class, "index"],
    "/home" => [App\Controller\HomeController::class, "index"],
    # Property Type
    "/property-types" => [App\Controller\PropertyTypeController::class, "index"],
    "/property-types/create" => [App\Controller\PropertyTypeController::class, "create"],
    # City
    "/cities" => [App\Controller\CityController::class, "index"],
    "/cities/create" => [App\Controller\CityController::class, "create"],
    # Area
    "/areas" => [App\Controller\AreaController::class, "index"],
    "/areas/create" => [App\Controller\AreaController::class, "create"],
    # Property
    "/properties" => [App\Controller\PropertyController::class, "index"],
    "/properties/create" => [App\Controller\PropertyController::class, "create"],
    "/properties/edit" => [App\Controller\PropertyController::class, "edit"],
];

$method = $_SERVER['REQUEST_METHOD'];
$apiRoutes = [];
if ($method === "POST") {
    $apiRoutes = [
        "/api/property-types" => [App\Controller\ApiPropertyTypeController::class, "create"],
        "/api/cities" => [App\Controller\ApiCitiesController::class, "create"],
        "/api/areas" => [App\Controller\ApiAreaController::class, "create"],
        "/api/properties" => [App\Controller\ApiPropertyController::class, "create"]
    ];
}
elseif ($method === "GET") {
    $apiRoutes = [
        "/api/areas" => [App\Controller\ApiAreaController::class, "index"]
    ];
}
elseif ($method === "PUT") {
    $apiRoutes = [
        "/api/properties" => [App\Controller\ApiPropertyController::class, "replace"]
    ];
}
elseif ($method === "DELETE") {
    $apiRoutes = [
        "/api/properties" => [App\Controller\ApiPropertyController::class, "delete"]
    ];
}

$routes = array_merge($webRoutes, $apiRoutes);

$url = $_SERVER['REQUEST_URI'];
$parsedUrl = parse_url($url);
$urlPath = rtrim($parsedUrl["path"], "/");

session_start();

ob_start();

if (array_key_exists($urlPath, $routes)) {
    [$controller, $method] = $routes[$urlPath];
    $isApiRoute = array_key_exists($urlPath, $apiRoutes);
    $controller = new $controller();
    if (!$isApiRoute) {
        require_once __ROOT__ . "/App/View/layout/head.php";
        require_once __ROOT__ . "/App/View/layout/toolbar.php";
    }
    $routeResp = $controller->$method();
    if ($routeResp) {
        if (isset($routeResp["scripts"])) {
            echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>';
            foreach ($routeResp["scripts"] as $script) {
                echo "<script type='text/javascript' src='{$script}' ></script>";
            }
                ;
        }
        if ($isApiRoute) {
            $responseCode = $routeResp["responseCode"] ?? "200";
            unset($routeResp["responseCode"]);

            echo json_encode($routeResp);
            http_response_code($responseCode);
            die();
        }
    }
} else {
    $NOT_FOUND = 404;
    http_response_code($NOT_FOUND);
    die();
}
ob_end_flush();
