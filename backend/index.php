<?php

declare(strict_types=1);

require_once "./src/config/database.php";
require_once "./src/config/ErrorHandler.php";
$config = require "./src/config/config.php";

$databaseConfig = $config["database"]["config"];
$username = $config["database"]["username"];
$password = $config["database"]["password"];

spl_autoload_register(function ($class) {
    require __DIR__ . "/src/Product/$class.php";
});

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

// header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset=UTF-8");

$http = explode("/", $_SERVER["REQUEST_URI"]);

if ($http[1] !== "products") {
    http_response_code(404);
    exit;
}

// $id = $http[2] ?? null;

$database = new Database($databaseConfig, $username, $password);

$gateway = new ProductGateway($database);

$controller = new ProductController($gateway);

$controller->handleRequest($_SERVER["REQUEST_METHOD"]);
