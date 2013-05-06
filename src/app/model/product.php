<?php

namespace app\model;

/**
 * @Entity
 */
class Product
{
    private $id;
    private $name;
    private $description;

    /**
     * @ProductCategory
     * @Fetch = "eager"
     */
    private $productCategory;
    private $price;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getProductCategory()
    {
        return $this->productCategory;
    }

    public function setProductCategory($productCategory)
    {
        $this->productCategory = $productCategory;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }
}

?>