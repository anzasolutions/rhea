<?php

namespace core\view\model;

use core\view\dom\Option;

class SelectItem
{
    private $label;
    private $value;
    private $selected;
    
    public function __construct($label, $value)
    {
        $this->label = $label;
        $this->value = $value;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function isSelected()
    {
        return $this->selected;
    }

    public function setSelected($selected)
    {
        $this->selected = $selected;
    }

    public function __toString()
    {
        $option = $this->createOption();
        return $option->__toString();
    }

    private function createOption()
    {
        $option = new Option($this->value);
        $option->setSelected($this->selected);
        $option->setLabel($this->label);
        return $option;
    }
}

?>