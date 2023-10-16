<?php

abstract class Product
{
    private $sku;
    private $name;
    private $price;

    public function __construct($sku, $name, $price)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
    }

    public function getSKU()
    {
        return $this->sku;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function toJson()
    {
        $filteredData = [];
        foreach ($this as $key => $value) {
            if ($value !== null) {
                $filteredData[$key] = $value;
            }
        }
        return json_encode($filteredData);
    }

    abstract public function getDescription();

    abstract public function getType();

    abstract public function getSpecificFields();
}
