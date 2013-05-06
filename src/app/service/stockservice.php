<?php

namespace app\service;

use core\db\exception\DuplicateException;
use core\db\exception\NoResultException;
use core\service\AbstractService;
use core\service\ServiceException;

use app\model\Product;
use app\model\ProductCategory;

class StockService extends AbstractService
{
    public function add($name, $description, $price, $categoryId)
    {
        $category = new ProductCategory();
        $category->setId($categoryId);
        
        $product = new Product();
        $product->setName($name);
        $product->setDescription($description);
        $product->setPrice($price);
        $product->setProductCategory($category);
        
        $this->dao->product->save($product);
    }

    public function getCategories()
    {
        return $this->dao->productCategory->findAll();
    }

    public function getLatestProducts($limit = 5)
    {
        try
        {
            return $this->dao->product->findLatest($limit);
        }
        catch (NoResultException $e)
        {
            throw new ServiceException();
        }
    }

    public function newCategory($name)
    {
        try
        {
            $category = new ProductCategory();
            $category->setName($name);
            $this->dao->productCategory->save($category);
        }
        catch (DuplicateException $e)
        {
            throw new ServiceException($e);
        }
    }

    public function removeCategory($categoryId)
    {
        try
        {
            $category = $this->dao->productCategory->findById($categoryId);
            $this->dao->productCategory->delete($category);
        }
        catch (NoResultException $e)
        {
            throw new ServiceException($e);
        }
    }
}

?>