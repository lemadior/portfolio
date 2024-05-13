<?php

namespace application\core\types;

class Type_Product extends Type_Goods
{
    protected $type;
    protected $fields;
    protected $sku;
    protected $price;
    protected $attributeValue;

    public function __construct($id, $name, $sku, $price, $attr, $type, $fields)
    {
        parent::__construct($id, $name);

        $this->sku = $sku;
        $this->price = $price;
        $this->attributeValue = $attr;
        $this->type = $type;
        $this->fields = $fields;
    }

    public function getAttributeValue()
    {
        return $this->attributeValue;
    }

    public function setAttributeValue($attr)
    {
        $this->attributeValue = $attr;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function setFields($fields)
    {
        $this->fields = $fields;
    }

}
