<?php

namespace core\view\dom;

class Span extends DOMObject
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
        return '<span ' . $this->id . $this->name . $this->class . $this->style . '>' . $this->content . '</span>' . "\n";
    }
}

?>