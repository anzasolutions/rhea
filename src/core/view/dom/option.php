<?php

namespace core\view\dom;

class Option extends DOMObject
{
    private $value;
    private $selected;
    private $label;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function setSelected($selected)
    {
        if ($selected)
        {
            $this->selected = ' selected';
        }
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function __toString()
    {
        return '<option value="' . $this->value . '" ' . $this->selected . $this->class . $this->style . '>' . $this->label . '</option>' . "\n";
    }
}

?>