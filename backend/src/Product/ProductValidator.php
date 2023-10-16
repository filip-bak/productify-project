<?php

class ProductValidator
{
    public function getValidationErrors(array $data): array
    {
        $errors = [];

        if (empty($data["sku"])) {
            $errors[] = "sku is required";
        }
        if (empty($data["name"])) {
            $errors[] = "name is required";
        }
        if (empty($data["price"])) {
            $errors[] = "price is required";
        }
        if (empty($data["type"])) {
            $errors[] = "type is required";
        }

        $errors = $this->validateProductTypes($data, $errors);

        return $errors;
    }



    private function validateProductTypes(array $data, array $errors): array
    {
        if (!array_key_exists("type", $data)) return $errors;

        switch ($data["type"]) {
            case 'Book':
                return $this->validateTypeProperties("weight", $data);
            case 'DVD':
                return $this->validateTypeProperties("size", $data, FILTER_VALIDATE_INT);
            case 'Furniture':
                $widthErr = $this->validateTypeProperties("width", $data);
                $heightErr = $this->validateTypeProperties("height", $data);
                $lengthErr = $this->validateTypeProperties("length", $data);

                return [...$widthErr, ...$heightErr, ...$lengthErr];
        }
        return $errors;
    }

    private function validateTypeProperties(string $key, array $data, int $filter = FILTER_VALIDATE_FLOAT): array
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
