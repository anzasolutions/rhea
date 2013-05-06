<?php

namespace core\view\dom;

class Image extends DOMObject
{
    private $src;

    public function __construct($src)
    {
        $this->src = $src;
    }

    public function __toString()
    {
        return '<img src="' . $this->src . '"' . $this->id . $this->name . $this->class . $this->style . ' />' . "\n";
    }
}

?>