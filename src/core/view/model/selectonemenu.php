<?php

namespace core\view\model;

use core\view\dom\Select;

class SelectOneMenu
{
    private $items;
    private $name;
    
    public function add(SelectItem $item)
    {
        $this->items[] = $item;
    }
    
    public function __toString()
    {
        $select = $this->createSelect();
        return $select->__toString();
    }
    
    private function createSelect()
    {
        $select = new Select($this->itemsAsString());
        $select->addName($this->name);
        return $select;
    }
    
    private function itemsAsString()
    {
        $items = '';
        foreach ($this->items as $item)
        {
            $items .= $item;
        }
        return $items;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}

?>