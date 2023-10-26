<?php

require_once "models/Product.php";
require_once "models/Book.php";
require_once "models/Furniture.php";
require_once "models/DVD.php";


class ProductBuilder
{
    private static $productTypes = [
        'DVD' => DVD::class,
        'Book' => Book::class,
        'Furniture' => Furniture::class,
    ];


    // Validate Types of Products
    public static function createProduct(array $data): Product
    {
        if (array_key_exists($data["type"], self::$productTypes)) {
            $className = self::$productTypes[$data["type"]];
            $product = $className::createProduct($data);
            return $product;
        }
        throw new InvalidArgumentException('Invalid product type.', 400);
    }
}
