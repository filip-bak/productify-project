<?php

declare(strict_types=1);

require_once "./src/config/Database.php";
require_once "./src/config/ErrorHandler.php";
$config = require "./src/config/config.php";

$databaseConfig = $config["database"]["config"];
$username = $config["database"]["username"];
$password = $config["database"]["password"];
$origin  = $config["cors"]["allowed_origin"];

spl_autoload_register(function ($class) {
    require __DIR__ . "/src/Product/$class.php";
});

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

header("Access-Control-Allow-Origin: $origin");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-type: application/json; charset=UTF-8");

$http = explode("/", $_SERVER["REQUEST_URI"]);
$endpoint = $http[3] ?? "";

if ($http[1] !== "api" || $http[2] !== "index.php" || $endpoint !== "products") {
    http_response_code(404);
    echo json_encode(["message"=>"Endpoint Not Found"]);
    exit;
}

// $id = $http[2] ?? null;

$database = new Database($databaseConfig, $username, $password);

$gateway = new ProductGateway($database);

$controller = new ProductController($gateway);

$controller->handleRequest($_SERVER["REQUEST_METHOD"], $http);
