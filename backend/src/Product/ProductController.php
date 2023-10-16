<?php

require_once "models/Product.php";
require_once "models/Book.php";
require_once "models/Furniture.php";
require_once "models/DVD.php";

class ProductController
{
    private $validMethods = [
        'GET' => 'handleGetAllProducts',
        'POST' => 'handleAddProduct',
        'DELETE' => 'handleDeleteProducts',
    ];


    public function __construct(private ProductGateway $gateway)
    {
    }

    public function handleRequest(string $method): void
    {
        $this->handleCollectionRequest($method);
    }

    private function handleCollectionRequest(string $method)
    {

        if (isset($this->validMethods[$method])) {
            $handlerMethod = $this->validMethods[$method];

            $this->$handlerMethod();
            return;
        }
        http_response_code(405);
        header("Allow: GET, POST, DELETE");
    }

    private function handleGetAllProducts()
    {
        try {
            http_response_code(200);
            echo json_encode($this->gateway->getAllProducts());
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["message" => "Ops something went wrong."]);
        }
    }

    private function handleAddProduct()
    {
        $data = (array) json_decode(file_get_contents("php://input"), true);

        // Validation
        $productValidator = new ProductValidator();
        $errors = $productValidator->getValidationErrors($data);

        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode(["errors" => $errors]);
            return;
        }

        // Request
        try {
            $product = ProductBuilder::createProduct($data);

            $this->gateway->addProduct($product);
            http_response_code(201);
            echo json_encode([
                "message" => "Product added",
            ]);
        } catch (InvalidArgumentException $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        } catch (Throwable $e) {
            if ($e->getCode() === "23000") {
                http_response_code(409);
                echo json_encode(['message' => 'This SKU already exists.']);
            }
        }
    }
    private function handleDeleteProducts()
    {
        $body = json_decode(file_get_contents('php://input'), true);

        $productIds = $body['productIds'] ?? [];
        try {

            $rows = $this->gateway->deleteProducts($productIds);

            if ($rows === 0) {
                http_response_code(404);
                echo json_encode(["message" => "Not Found"]);
                return;
            }

            http_response_code(200);
            echo json_encode([
                "deleted" => $rows,
                "message" => "Products deleted"
            ]);
        } catch (Exception $e) {
            http_response_code($e->getCode());
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
}
