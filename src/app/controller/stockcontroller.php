<?php

namespace app\controller;

use core\controller\Controller;
use core\service\ServiceException;

/**
 * @Session
 * @Role = "admin"
 */
class StockController extends Controller
{
    /**
     * @Invocable
     */
    protected function index()
    {
        $this->setAction('products');
    }
    
    /**
     * @BeforeForm = "newproduct, removecategory"
     */
    protected function getCategories()
    {
        $this->categories = $this->service->stock->getCategories();
    }

    /**
     * @Invocable
     * @Form = "newproduct"
     */
    protected function add($form)
    {
        $categoryId = $form->getCategory();
        $name = $form->getName();
        $description = $form->getDescription();
        $price = $form->getPrice();
        
        $this->service->stock->add($name, $description, $price, $categoryId);
        $this->redirectTo('stock');
    }

    /**
     * @Invocable
     */
    protected function products()
    {
        $this->getLatestProducts();
    }

    private function getLatestProducts()
    {
        try
        {
            $this->products = $this->service->stock->getLatestProducts();
        }
        catch (ServiceException $e)
        {
            // FIXME: wrong text message!
            $this->error = $this->bundle->getText('video.message.error.no.videos');
        }
    }

    /**
     * @Invocable
     */
    protected function edit()
    {
    }

    /**
     * @Invocable
     * @Form = "newcategory"
     */
    protected function newCategory($form)
    {
        try
        {
            $name = $form->getName();
            $this->service->stock->newCategory($name);
            $this->redirectTo('stock');
        }
        catch (ServiceException $e)
        {
            $this->error = $this->bundle->getText('stock.new.category.error');
        }
    }
    
    /**
     * @Invocable
     * @Form = "removecategory"
     */
    protected function removeCategory($form)
    {
        try
        {
            $categoryId = $form->getCategory();
            $this->service->stock->removeCategory($categoryId);
            $this->redirectTo('stock');
        }
        catch (ServiceException $e)
        {
            $this->error = $this->bundle->getText('stock.remove.category.error');
            $this->log->error($this->error.' '.$categoryId, $e);
        }
    }
}

?>