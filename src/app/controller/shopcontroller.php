<?php

namespace app\controller;

use core\controller\Controller;
use core\service\ServiceException;

/**
 * @Session
 */
class ShopController extends Controller
{
    /**
     * @PostConstruct
     */
    public function init()
    {
        parent::init();
        $this->categories = $this->service->stock->getCategories();
    }

    /**
     * @Invocable
     */
    protected function index()
    {
        $oldestCategory = $this->categories[0];
        $this->url->setParameters($oldestCategory->getId());
        $this->setAction('category');
    }

    /**
     * @Invocable
     */
    protected function category()
    {
        $this->getCategoryProducts();
    }

    private function getCategoryProducts()
    {
        try
        {
            $category = $this->url->getParameter(0);
            $this->products = $this->service->shop->getCategoryProducts($category);
        }
        catch (ServiceException $e)
        {
            $this->error = $this->bundle->getText('shop.message.error.no.products');
        }
    }
}

?>