<?php

namespace app\view;

use core\view\model\SelectOneMenu;
use core\view\model\SelectItem;

class StockView extends MenuView
{
    /**
     * @MenuItem
     * @MenuBundle = "link.header.stock.product.add"
     */
    protected function add()
    {
        $template = new FormWrapper('stock.add.product.form.label.name');
        $this->checkErrors($template);
        $template->form->selectCategory = $this->buildCategories();
        $template->render();
    }

    /**
     * @MenuItem
     * @MenuBundle = "link.header.stock.products"
     */
    protected function products()
    {
        $this->checkErrors();

        if ($this->values->hasKey('products'))
        {
            $products = array();
            foreach ($this->products as $product)
            {
                $element['title'] = $product->getName();
                $element['link'] = $this->url->build('stock', 'product', $product->getId());
                $element['description'] = $product->getDescription();
                $element['category'] = $product->getProductCategory()->getName();
                $element['categoryLink'] = $this->url->build('stock', 'productCategory', $product->getProductCategory()->getId());
                $products[] = $element;
            }
            $this->template->products = $products;
        }

        $this->template->show($this->url->getActionPath());
    }

    /**
     * @MenuItem
     * @MenuBundle = "link.header.stock.category.new"
     */
    protected function newCategory()
    {
        $template = new FormWrapper('stock.new.category.form.name');
        $this->checkErrors($template);
        $template->render();
    }

    /**
     * @MenuItem
     * @MenuBundle = "link.header.stock.category.remove"
     */
    protected function removeCategory()
    {
        $template = new FormWrapper('stock.remove.category.form.name');
        $this->checkErrors($template);
        $template->form->selectCategory = $this->buildCategories();
        $template->render();
    }
    
    private function buildCategories()
    {
        $menu = new SelectOneMenu();
        $menu->setName('category');
        $menu->add(new SelectItem('-- Select --', 0));
        foreach ($this->categories as $category)
        {
            $item = new SelectItem($category->getName(), $category->getId());
            $item->setSelected($this->request->{$menu->getName()} == $category->getId());
            $menu->add($item);
        }
        return $menu;
    }
}

?>