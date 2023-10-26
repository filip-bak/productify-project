<?php

class ProductValidator
{
    public function getValidationErrors(array $data): array
    {
        $errors = [];
        if (empty($data["sku"]) || $data["sku"] === "") {
            $errors[] = "sku is required";
        }
        if (empty($data["name"])) {
            $errors[] = "name is required";
        }

        $errors = array_merge($errors, $this->validateProductProperty("price", $data));

        // if (empty($data["price"])) {
        //     $errors[] = "price is required";
        // } else {
        //     if (filter_var($data["price"], 259) === false) {
        //         $errors[] = "price must be a numeric value";
        //     }
        // }

        if (empty($data["type"])) {
            $errors[] = "type is required";
        }

        if (count($errors) === 0)
            $errors = $this->validateProductTypes($data);

        return $errors;
    }




    private function validateProductTypes(array $data): array
    {

        $errors = [];

        if (!array_key_exists("type", $data)) return $errors;

        switch ($data["type"]) {
            case 'Book':
                return [...$this->validateProductProperty("weight", $data)];
            case 'DVD':
                return [...$this->validateProductProperty("size", $data, FILTER_VALIDATE_INT)];
            case 'Furniture':
                $widthErr = $this->validateProductProperty("width", $data);
                $heightErr = $this->validateProductProperty("height", $data);
                $lengthErr = $this->validateProductProperty("length", $data);

                return [...$widthErr, ...$heightErr, ...$lengthErr];
        }

        return $errors;
    }

    private function validateProductProperty(string $key, array $data, int $filter = FILTER_VALIDATE_FLOAT)
    {
        $errors = [];

        if (array_key_exists($key, $data)) {
            if (filter_var($data[$key], $filter) === false) {
                $errors[] = "$key must be a " . ($filter === FILTER_VALIDATE_INT ? "integer" : "numeric value");
            }
        } else {
            $errors[] = "$key is required";
        }

        return $errors;
    }
}
