<?php

namespace app\view;

use core\system\template\Template;

class ShopView extends MenuView
{
    public function index()
    {
    }

    /**
     * Overrides in order to display product categories as submenu items
     */
    protected function createContextMenu()
    {
        if (sizeof($this->categories) == 0)
        {
            return;
        }
         
        $links = array();
        foreach ($this->categories as $category)
        {
            $element['link'] = $this->url->build($this->url->getController(), 'category', $category->getId());
            $element['title'] = $category->getName();
            $links[] = $element;
        }
        $template = new Template('menu-context', 'common');
        $template->links = $links;
        return $template;
    }

    protected function category()
    {
        $this->createContextMenu();
        $this->checkErrors();

        if ($this->values->hasKey('products'))
        {
            $products = array();
            foreach ($this->products as $product)
            {
                $element['title'] = $product->getName();
                $element['link'] = $this->url->build('stock', 'product', $product->getId());
                $element['description'] = $product->getDescription();
                $element['price'] = $product->getPrice();
                $products[] = $element;
            }
            $this->template->products = $products;
        }

        $this->template->show($this->url->getActionPath());
    }
}

?>