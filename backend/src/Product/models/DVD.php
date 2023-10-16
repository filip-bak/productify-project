<?php

require_once 'Product.php';

class DVD extends Product
{
    private $sizeMb;
    private $type;

    public function __construct($sku, $name, $price, $type, $sizeMb)
    {
        parent::__construct($sku, $name, $price);
        $this->setType($type);
        $this->setSize($sizeMb);
    }

    public function getSize()
    {
        return $this->sizeMb;
    }

    public function setSize($sizeMb)
    {
        $this->sizeMb = $sizeMb;
    }

    public function getType()
    {
        return $this->type;
    }
    public function setType()
    {
        $this->type = get_class($this);
    }

    public static function createProduct(array $data)
    {
        $sku = $data["sku"];
        $name = $data["name"];
        $price = $data["price"];
        $type = $data["type"];
        $size = $data["size"];
        return new self($sku, $name, $price, $type, $size);
    }
    public function getSpecificFields()
    {
        return [
            'size' => $this->getSize(),
        ];
    }

    public function getDescription()
    {
        return "Size: {$this->sizeMb} MB";
    }
}
