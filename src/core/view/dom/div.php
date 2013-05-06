<?php

namespace core\view\dom;

class Div extends DOMObject
{
    private $content;

    public function __construct($content = null)
    {
        $this->content = $content;
    }

    public function addContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function __toString()
    {
        return '<div ' . $this->id . $this->name . $this->class . $this->style . '>' . $this->content . '</div>' . "\n";
    }
}

?>