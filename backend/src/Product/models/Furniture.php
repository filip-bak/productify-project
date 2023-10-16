<?php

require_once 'Product.php';

class Furniture extends Product
{
    private $height;
    private $width;
    private $length;
    private $type;

    public function __construct($sku, $name, $price, $type, $height, $width, $length)
    {
        parent::__construct($sku, $name, $price);
        $this->type = $type;
        $this->width = $width;
        $this->height = $height;
        $this->length = $length;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getLength()
    {
        return $this->length;
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
            'height' => $this->getHeight(),
            'width' => $this->getWidth(),
            'length' => $this->getLength(),
        ];
    }

    public static function createProduct(array $data)
    {
        $sku = $data["sku"];
        $name = $data["name"];
        $price = $data["price"];
        $type = $data["type"];
        $width = $data["width"];
        $height = $data["height"];
        $length = $data["length"];
        return new self($sku, $name, $price, $type, $width, $height, $length);
    }

    public function getDescription()
    {
        return "Dimensions: {$this->height}x{$this->width}x{$this->length} inches";
    }
}
