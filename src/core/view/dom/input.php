<?php

namespace core\view\dom;

class Input extends DOMObject
{
    private $type;
    private $value;

    public function __construct($type, $value)
    {
        $this->name = $name;
        $this->type = $type;
        $this->value = $value;
    }

    public function __toString()
    {
        return '<input ' . $this->name . ' type="' . $this->type . '" value="' . $this->value . '" />' . "\n";
    }
}

?>