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
        "OPTIONS" => "handleCors"
    ];


    public function __construct(private ProductGateway $gateway)
    {
    }

    public function handleRequest(string $method, array $http): void
    {   
        if (isset($http[4]) && strtolower($http[4]) === "delete") {
          $method = 'DELETE';
        }
        
        $this->handleCollectionRequest($method);
    }

    private function handleCollectionRequest(string $method)
    {
        if (isset($this->validMethods[$method])) {
            $handlerMethod = $this->validMethods[$method];

            $this->$handlerMethod();
        } else {
            http_response_code(405);
            // header("Allow: GET, POST, DELETE");
        }
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
        $data = (array) json_decode(file_get_contents("php://input"), true);

        $productIds = $data['productIds'] ?? [];
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

    // private function handleDeleteProducts()
    // {
    //     $data = (array) json_decode(file_get_contents("php://input"), true) ?: [];
        
    //     $productIds = $data['productIds'] ?? [];
    //         var_dump($productIds);
    //     // if (is_numeric($productIds)) {
    //     //     http_response_code(400);
    //     //     echo json_encode(["message" => "Invalid productIds. Must be a array."]);
    //     //     return;
    //     // }
        
    //     try {
            
    //         // $rows = $this->gateway->deleteProducts($productIds);
    //         // var_dump($rows);

    //         // if ($rows === 0) {
    //         //     http_response_code(404);
    //         //     echo json_encode(["message" => "Not Found"]);
    //         //     return;
    //         // }

    //         http_response_code(200);
    //         echo json_encode([
    //             "message" => "Products deleted"
    //         ]);
    //     } catch (Exception $e) {
    //         http_response_code($e->getCode());
    //         echo json_encode(["message" => $e->getMessage()]);
    //     }
    // }

    private function handleCors()
    {
        header("Access-Control-Allow-Origin: http://localhost:3000");
        header("Access-Control-Allow-Methods: GET, POST");
        header("Access-Control-Allow-Headers: Content-Type");
        header("Access-Control-Max-Age: 3600");
        header("Content-Length: 0");
        http_response_code(204);
        exit;
    }
}
