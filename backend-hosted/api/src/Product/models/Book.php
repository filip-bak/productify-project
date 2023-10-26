<?php

require_once 'Product.php';


class Book extends Product
{
    private $weight;
    private $type;

    public function __construct($sku, $name, $price, $type, $weight)
    {
        parent::__construct($sku, $name, $price);
        $this->setType($type);
        $this->setWeight($weight);
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function getType()
    {
        return $this->type;
    }
    public function setType()
    {
        $this->type = get_class($this);
    }

    public function getSpecificFields()
    {
        return [
            'weight' => $this->getWeight(),
        ];
    }

    public static function createProduct(array $data)
    {
        $sku = $data["sku"];
        $name = $data["name"];
        $price = $data["price"];
        $type = $data["type"];
        $weight = $data["weight"];
        return new self($sku, $name, $price, $type, $weight);
    }

    public function getDescription()
    {
        return "Weight: {$this->weight} Kg";
    }
}
