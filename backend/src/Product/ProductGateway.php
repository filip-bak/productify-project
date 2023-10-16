<?php

class ProductGateway
{
    private $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    public function getAllProducts()
    {
        $sql = "select * from products";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $filteredRow = array_filter($row, function ($value) {
                return $value !== null;
            });
            $data[] = $filteredRow;
        }

        return $data;
    }

    public function addProduct(Product $product): void
    {
        $fields = $this->prepareFields($product);


        $keys = array_keys($fields);

        $data =  implode(', ', $keys);
        $values = implode(', :', $keys);

        $sql = "INSERT INTO products ($data) 
                VALUES (:" . $values . ")";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($fields);

        return;
    }

    public function deleteProducts(array $productIds)
    {
        $placeholders = implode(',', array_fill(0, count($productIds), '?'));

        $sql = "DELETE from products where id IN ($placeholders)";

        if ($placeholders === "") {
            throw new Exception("No product IDs provided for deletion.", 400);
        }

        try {
            $stmt = $this->conn->prepare($sql);

            foreach ($productIds as $key => $cardId) {
                $stmt->bindValue(($key + 1), $cardId, PDO::PARAM_INT);
            }

            $stmt->execute();


            return $stmt->rowCount();
        } catch (PDOException $e) {
            http_response_code($e->getCode());
            echo json_encode(["message" => $e->getMessage()]);
            return;
        }
    }

    private function prepareFields(Product $product)
    {
        $fields = [
            'sku' => $product->getSku(),
            'name' => $product->getName(),
            'price' => $product->getPrice(),
            'type' => $product->getType(),
        ];

        $specificFields = $product->getSpecificFields();
        $fields = array_merge($fields, $specificFields);

        return $fields;
    }
}
